<?php
use vezit\dto\class\session\order\item\Item;
use vezit\dto\session\response\Session_Response;
use vezit\dto\get_session\response\Get_Session_Response;
use vezit\services\session_service\Session_Service;
use \PHPUnit\Framework\TestCase;
require __DIR__ . '/../global-requirements.php';

class Session_Service_Test extends TestCase {

    protected function setUp() : void
    {
        $this->session_service = Session_Service::get_instance();
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
        $this->assertInstanceOf(Get_Session_Response::class, $session_response);
    }



    // /** @test */
    // public function get_session__you_should_be_able_to_change_the_order_items()
    // {
    //     $session_response = $this->session_service->get_session();

    //     $order_item = new Item("product_name", 1, 100, 1);
    //     $order_items = [$order_item];

    //     $session_response->session->order->set_order_items($order_items);

    //     $this->assertInstanceOf(Order_Item::class, $session_response->session->order->get_order_items()[0]);
    // }



}

