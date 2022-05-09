<?php
use vezit\dto\class\session\order\item\Item;
use vezit\dto\session\response\Session_Response;
use vezit\services\session_service\Session_Service;
use \PHPUnit\Framework\TestCase;
require __DIR__ . '/../global-requirements.php';

class Session_Service_Test extends TestCase {

    protected function setUp() : void
    {
        $this->session_service = new Session_Service();
    }

    protected function tearDown() : void
    {
        $this->session_service = null;
    }


    /** @test */
    public function get_session__shall_return_correct_instance_of_class_when_object_is_unserialized_from_stored_session_variable()
    {
        // Setup
        $this->session_service->get_session();

        // Do something
        $session_response = $this->session_service->get_session();

        // Assert
        $this->assertInstanceOf(Session_Response::class, $session_response);
    }


    /** @test */
    public function get_session__an_exception_will_be_thrown_when_trying_add_wrong_type_of_data_to_sub_objects_inside_session_reponse()
    {
        // Setup
        $session_response = $this->session_service->get_session();
        // Do something
        try {

            $session_response->session->order->order_id = "femtem";
            $this->fail("A TypeError should have been thrown");


        } catch (TypeError $error) {
            $this->assertStringStartsWith('Cannot assign string', $error->getMessage());
        }

        // Assert
        $this->assertInstanceOf(Session_Response::class, $session_response);
    }


    /** @test */
    public function get_session__you_should_be_able_to_change_the_order_items()
    {
        $session_response = $this->session_service->get_session();

        $order_item = new Item("product_name", 1, 100, 1);
        $order_items = [$order_item];

        $session_response->session->order->set_order_items($order_items);

        $this->assertInstanceOf(Order_Item::class, $session_response->session->order->get_order_items()[0]);
    }



}

