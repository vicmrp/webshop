<?php
use \PHPUnit\Framework\TestCase;
use vezit\entities\Session;
use vezit\entities\Sessions;
use vezit\repositories\session_repository\Session_Repository;
use vezit\repositories\super_repository\Super_Repository;
use vezit\entities\Session_Order_Items;
use vezit\classes\mysqli\Mysqli;
use vezit\entities\Session_Order_Item;

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
    protected function setUp() : void
    {
        $this->session_repository = Session_Repository::get_instance(
            Super_Repository::get_instance(
                Mysqli::get_instance(
                    'localhost', 'test', 'Passw0rd', 'test_user_v6_vezit_webshop'
                )
            )
        );
    }

    // ------- Read -------
    /** @test */
    public function get_all__expects_to_return_object_of_sessions()
    {
        // Act
        $sessions = $this->session_repository->get_all();

        // Assert
        foreach ($sessions as $session) {
            if (!($session instanceof Session)) {
                $this->fail('Session_Repository::get_all() shall return an array of Session_Entity objects');
            }

            foreach($session->get_session_order_items() as $session_order_item) {
                if(!($session_order_item instanceof Session_Order_Item)) {
                    $this->fail('Session_Repository::get_all() shall return an array of Session_Entity objects');
                }
            }
        }

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
    // ------- Read -------




    // ------- Write -------
    /** @test */
    public function insert__check_if_can_successfully_insert_a_new_session_element_to_table_without_any_slave_objects_to_database() {
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

        $session_order_items = new Session_Order_Items();
        $session_order_item_1 = new Session_Order_Item($pk = null,
                                                     $fk = null,
                                                     $product_pk = 3,
                                                     null,
                                                     null,
                                                     $name = "Steen's Roman",
                                                     $price = 25000, $quantity = 10);
        $session_order_item_2 = new Session_Order_Item($pk = null,
                                                     $fk = null,
                                                     $product_pk = 4,
                                                     null,
                                                     null,
                                                     $name = "Steen's Karriere",
                                                     $price = 40000, $quantity = 15);

        $session_order_items->set([$session_order_item_1, $session_order_item_2]);


        $session = new Session(

            $session_pk                                     = null,
            $order_id                                       = $new_order_id,
            $datetime_created                               = null,
            $datetime_last_modified                         = null,
            $order_status_payment_accepted                  = false,
            $order_status_payment_currency                  = "DKK",
            $order_status_payment_amount                    = 50000,
            $order_status_payment_quickpay_id               = $new_quickpay_id,
            $order_status_payment_details_satisfied         = true,
            $order_status_email_confirmation_sent           = false,
            $order_status_email_invoice_sent_to_customer    = false,
            $customer_fullname                              = "Victor Reipur",
            $customer_details_satisfied_for_payment         = true,
            $customer_address_street                        = "Vinkelvej 12D, 3tv",
            $customer_address_postal_code                   = 2800,
            $customer_address_city                          = "Lyngby",
            $customer_contact_phone                         = "26129604",
            $customer_contact_email                         = "victor.reipur@gmail.com",
            $customer_company_cvr_number                    = null,
            $customer_company_name                          = null,
            $shipment_tracking_number                       = null,
            $shipment_order_collected                       = false,
            $shipment_details_satisfied                     = true,
            $shipment_address_street_name                   = "Vinkelvej 12D, 3tv",
            $shipment_address_street_number                 = "12D, 3tv",
            $shipment_address_postal_code                   = 2800,
            $shipment_address_city                          = "Lyngby",

            $session_order_items

        );

        $updated_successfully = $this->session_repository->insert($session);
        $get_inserted_row = $this->session_repository->get_by_pk($new_session_pk);

        $this->assertTrue($updated_successfully);
        $this->assertEquals($new_order_id, $get_inserted_row->order_id);

    }


    /** @test */
    public function update__check_if_you_can_succesfully_update_a_session_object_to_database()
    {
        // Setup
        $sessions = $this->session_repository->get_all();

        (int)$first_array_key = array_key_first($sessions->get());

        $first_session_object_in_collection = $sessions->get()[$first_array_key];


        // Act
        $datetime = new \DateTime; // Forventes ikke ændret
        $pk = $first_session_object_in_collection->session_pk;

        $first_session_object_in_collection->customer_fullname = g_generate_random_string();
        $first_session_object_in_collection->session_pk = 0;
        $first_session_object_in_collection->order_id = 0;
        $first_session_object_in_collection->order_status_payment_accepted = false;
        $first_session_object_in_collection->datetime_created = $datetime;
        $first_session_object_in_collection->datetime_last_modified = new \DateTime('now',);

        $has_been_updated = $this->session_repository->update($pk, $first_session_object_in_collection);

        $updated_session = $this->session_repository->get_by_pk($pk);

        // Assert
        $this->assertTrue($has_been_updated);
        $this->assertEquals($first_session_object_in_collection->customer_fullname, $updated_session->customer_fullname);
        $this->assertNotEquals($updated_session->session_pk, $first_session_object_in_collection->session_pk);
        $this->assertNotEquals($updated_session->order_id, $first_session_object_in_collection->order_id);
        $this->assertNotEquals($updated_session->datetime_created, $first_session_object_in_collection->datetime_created);


    }


    /** @test */
    public function update__check_if_you_can_succesfully_modify_a_session_order_item_object_in_a_session_object_and_update_it_to_database() {
        $sessions = $this->session_repository->get_all();

        (int)$first_array_key = array_key_first($sessions->get());

        $first_session_object_in_collection = $sessions->get()[$first_array_key];

        // Act - Make a change to one of the items in order items list
        $session_order_items = $first_session_object_in_collection->get_session_order_items();

        $first_session_order_item = $session_order_items[array_key_first($session_order_items)];
        $session_order_item_pk = $first_session_order_item->session_order_item_pk;
        // Change the price
        $first_session_order_item->price = rand(10000, 50000);
        $first_session_order_item->quantity = rand(10, 100);

        $pk = $first_session_object_in_collection->session_pk;
        $successfully_executed = $this->session_repository->update($pk, $first_session_object_in_collection);

        $first_session_object_in_collection->modify_session_order_item($first_session_order_item);


        $updated_session = $this->session_repository->get_by_pk($pk);
        $updated_price = $updated_session->get_session_order_items()[$session_order_item_pk]->price;
        $updated_quantity = $updated_session->get_session_order_items()[$session_order_item_pk]->quantity;

        $this->assertTrue($successfully_executed);
        $this->assertEquals($first_session_order_item->price, $updated_price);
        $this->assertEquals($first_session_order_item->quantity, $updated_quantity);




    }
    // ------- Write -------




}
