<?php
use \PHPUnit\Framework\TestCase;
use vezit\entities\Session;
use vezit\entities\Sessions;
use vezit\entities\Session_Order_Items;
use vezit\entities\Session_Order_Item;
use vezit\repositories\session_repository\Session_Repository;
use vezit\repositories\super_repository\Super_Repository;

use vezit\classes\mysqli\Mysqli;


require __DIR__ . '/../global-requirements.php';

// KRAV
// Der skal være fuld CRU
// Create
// Read
// Update
// Pa Sessions


// TODO Lav en test som garenterer at properties er magen til dens column name.

class Session_Repository_Test extends TestCase
{
    public $session_repository = null;

    protected function setUp() : void
    {
        $this->session_repository = Session_Repository::get_instance(

            // You can use this part of code to point to another database
            Super_Repository::get_instance(
                Mysqli::get_instance(
                    'database-service', 'testuser', 'Passw0rd', 'test_user_vezit_v3'
                )
            )



        );
    }



    // Check if there is a connection to the database
    /** @test */
    public function get_all__expects_to_return_a_session_repository_object() {
        // Act
        $session_repository = $this->session_repository;

        // Assert
        $this->assertInstanceOf(Session_Repository::class, $session_repository);

        // Get all sessions
        $sessions = $session_repository->get_all();

        // Assert
        $this->assertInstanceOf(Sessions::class, $sessions);

    }











    /**
     *  @test
     *  @depends get_all__expects_to_return_a_session_repository_object
     *
     */

    public function get_all__expects_to_return_a_sessions_object_where_the_key_is_the_order_id() {
        $session_repository = $this->session_repository;

        // Act
        $sessions = $session_repository->get_all($key = 'order_id');

        // get the first key in the array
        $first_array_key = array_key_first($sessions->get());

        // Expext the key to be the order_id
        $this->assertEquals($first_array_key, $sessions->get()[$first_array_key]->order_id);
        $this->assertInstanceOf(Sessions::class, $sessions);


    }















    /** @test */
    public function get_by_pk__expects_to_return_1_session_object() {
        // Setup
        $sessions = $this->session_repository->get_all();

        (int)$first_array_key = array_key_first($sessions->get());

        $first_session_object_in_collection = $sessions->get()[$first_array_key];

        // Act
        $response_session = $this->session_repository->get_by_pk($first_session_object_in_collection->session_pk);

        // Assert
        $this->assertInstanceOf(Session::class, $response_session);
        $this->assertEquals($first_array_key, $response_session->session_pk);

    }








    /** @test */
    public function get_by_order_id__expects_to_return_1_session_object() {
        // Setup
        $sessions = $this->session_repository->get_all();

        (int)$first_array_key = array_key_first($sessions->get());

        $first_session_object_in_collection = $sessions->get()[$first_array_key];

        // Act
        $response_session = $this->session_repository->get_by_order_id($first_session_object_in_collection->order_id);

        // Assert
        $this->assertInstanceOf(Session::class, $response_session);
        $this->assertEquals($first_session_object_in_collection->order_id, $response_session->order_id);

    }




























    // ------- Write -------

    /**
     * @test
     * @depends get_all__expects_to_return_a_session_repository_object
    */
    public function insert__before_after_user_has_pressed_the_payment_button() {
        // primary key sørger sql internt for at oprette
        // order_id skal du selv sørge for er unikt, i forhold til hvad der allerede ligger i databasen.
        // quickpay_id sørger quickpay for at være unikt

        // Setup

        $sessions = $this->session_repository->get_all();

        $sessions = $sessions->get();

        usort($sessions, function($a, $b) { return $b->order_id - $a->order_id; });
        $new_session_pk = $sessions[0]->session_pk + 1;
        $new_order_id = $sessions[0]->order_id + 1;
        $new_quickpay_id = $sessions[0]->order_status_payment_quickpay_id + 1;

        // Price is always 14900
        $price = 14900;
        // before payment is accepted
        $order_status_payment_accepted = false;

        $session_order_items = new Session_Order_Items();
        $session_order_item_1 = new Session_Order_Item($pk = null,
                                                     $fk = null,
                                                     $product_pk = 6,
                                                     null,
                                                     null,
                                                     $name = "victorsbog",
                                                     $price = $price,
                                                     $quantity = 1);


        $session_order_items->set([$session_order_item_1]);


        $session = new Session(


            $session_pk                                      = null
            ,$order_id                                       = $new_order_id
            ,$datetime_created                               = null
            ,$datetime_last_modified                         = null
            ,$order_status_payment_accepted                  = $order_status_payment_accepted
            ,$order_status_payment_currency                  = "DKK"
            ,$order_status_payment_amount                    = $price
            ,$order_status_payment_quickpay_id               = $new_quickpay_id
            ,$order_status_email_invoice_sent_to_customer    = false
            ,$customer_fullname                              = "Victor Reipur"
            ,$customer_tos_and_tac_has_been_accepted         = true
            ,$customer_contact_email                         = "victor.reipur@gmail.com"


            // sub entities
            ,$session_order_items

        );

        $updated_successfully = $this->session_repository->insert($session);
        $get_inserted_row = $this->session_repository->get_by_pk($new_session_pk);

        $this->assertTrue($updated_successfully);
        $this->assertEquals($new_order_id, $get_inserted_row->order_id);

    }


















































































    /**
     * @test
     * @depends get_all__expects_to_return_a_session_repository_object
     * @depends insert__before_after_user_has_pressed_the_payment_button
    */
    public function update__after_user_has_pressed_the_payment_button() {


        // Setup
        $sessions = $this->session_repository->get_all();
        $sessions = $sessions->get();
        usort($sessions, function($a, $b) { return $b->order_id - $a->order_id; });


        $session_pk_from_before_after_user_has_pressed_the_payment_button = $sessions[0]->session_pk;

        // Act

        // Get session from before
        $session = $this->session_repository->get_by_pk($session_pk_from_before_after_user_has_pressed_the_payment_button);

        // Update session
        $session->order_status_payment_accepted = true;
        $updated_successfully = $this->session_repository->update($session_pk_from_before_after_user_has_pressed_the_payment_button, $session);

        // Assert
        $this->assertTrue($updated_successfully);

    }



}