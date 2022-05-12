<?php
use \PHPUnit\Framework\TestCase;
use vezit\entities\Session;
use vezit\entities\Sessions;
use vezit\repositories\session_repository\Session_Repository;
use vezit\repositories\super_repository\Super_Repository;
use vezit\entities\Session_Order_Items;
use vezit\classes\mysqli\Mysqli;
require __DIR__ . '/../global-requirements.php';



class Session_Repository_Test extends TestCase
{
    protected function setUp() : void
    {
        $this->session_repository = new Session_Repository(new Super_Repository(new Mysqli('localhost', 'test', 'Passw0rd', 'test_user_v6_vezit_webshop')));

    }

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
        }

        $this->assertInstanceOf(Sessions::class, $sessions);
    }


    /** @test */
    public function get_by_pk__expects_to_return_1_session_object() {
        // Setup
        $sessions = $this->session_repository->get_all();

        (int)$first_array_key = array_key_first($sessions->get_sessions());

        $first_session_object_in_collection = $sessions->get_sessions()[$first_array_key];

        // Act
        $response_session = $this->session_repository->get_by_pk($first_session_object_in_collection->session_pk);

        $response_session_pk = $response_session->session_pk;

        $response_session_session_pk_fk = $response_session->session_order_items->get_session_order_items()[$response_session_pk]->session_pk_fk;

        // session_order_items->set_session_order_items($array)

        // Assert
        $this->assertInstanceOf(Session::class, $response_session);
        $this->assertEquals($first_session_object_in_collection->session_pk, $response_session->session_pk);
        $this->assertEquals($response_session_pk, $response_session_session_pk_fk);

    }


    /** @test */
    public function get_by_order_id__should_return_correct_object()
    {
        // Arrange


        // Act
        $order_id = 21;
        $session = $this->session_repository->get_by_order_id($order_id);

        // Assert
        $this->assertInstanceOf(Session::class, $session);
        $this->assertEquals($order_id, $session->order_id);
    }


    /** @test */
    public function insert__shall_successfully_insert_an_object_to_database() {
        // Act
        (array)$sessions = $this->session_repository->get_all();

        // Sorter sa første element i arrayet er højeste order_id
        usort($sessions, function ($a, $b) {
            return $b->order_id <=> $a->order_id;
        });


        (object)$session = $sessions[0];
        $session->order_id++;

        $this->assertTrue($this->session_repository->insert($session) , true);
    }


    /** @test */
    public function update__shall_succesfully_update_an_object_in_database()
    {
        // Act

        $order_id = 21;
        $session_before_update = $this->session_repository->get_by_order_id($order_id);


        $session_before_update->order_status_payment_amount++;
        $session_order_items_before_update = $session_before_update->get_session_order_items();

        array_walk($session_order_items_before_update, function (&$item) {
            $item->price++;
            $item->product_name = g_generate_random_string($length = 10);
        });

        $update_did_succeed = $this->session_repository->update($order_id, $session_before_update);
        $session_after_update = $this->session_repository->get_by_order_id($order_id);

        $this->assertTrue($update_did_succeed, true);
        $this->assertEquals($session_after_update->order_status_payment_amount, $session_before_update->order_status_payment_amount);
        foreach ($session_after_update->get_session_order_items() as $item) {
            $this->assertEquals($item->price, $session_before_update->get_session_order_items()[21]->price);
            $this->assertEquals($item->product_name, $session_before_update->get_session_order_items()[21]->product_name);
        }

    }



}
