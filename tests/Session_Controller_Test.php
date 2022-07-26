<?php
use \PHPUnit\Framework\TestCase;
use vezit\controllers\session_controller\Session_Controller;
use vezit\dto\Session_Order_Update_Request;
use vezit\dto\Session_Order_Update_Requests;

require __DIR__ . '/../global-requirements.php';

class Session_Controller_Test extends TestCase
{
    protected function setUp() : void
    {
        $this->session_controller = Session_Controller::get_instance('GET');
    }

    protected function tearDown(): void
    {
    }

    /** @test */
    public function get_json_response__get_session() {


        $json = $this->session_controller->get_json_response();
        $session = json_decode($json);

        $this->assertTrue(isset($session));

    }


    /** @test */
    public function get_json_response__update_customer() {

        $body = file_get_contents(__DIR__ . '/json/Session_Controller_Test_Update_Body.json');

        Session_Controller::destroy_instance();
        $this->session_controller = Session_Controller::get_instance(
            'PUT',
            ['update' => 'customer'],
            $body
        );

        $json = $this->session_controller->get_json_response();
        $updated_session = json_decode($json);
        $fullname = $updated_session->session->customer->fullname;

        $this->assertEquals("Victor Reipur", $fullname);

    }


    // /** @test */
    // public function get_json_response__update_shipment() {
    //     $body = file_get_contents(__DIR__ . '/json/Session_Controller_Test_Update_Shipment_Body.json');



    //     $session_controller = new Session_Controller(
    //         'PUT',
    //         ['update' => 'shipment'],
    //         $body,
    //         null
    //     );

    //     $json = $session_controller->get_json_response();


    //     $this->assertTrue(true);

    // }



    /** @test */
    public function get_json_response__update_order_items() {

        $body = '
        [
            {
                "product_pk": 3,
                "quantity": 14
            },
                {
                "product_pk": 4,
                "quantity": 14
                }
        ]';


        Session_Controller::destroy_instance();
        $this->session_controller = Session_Controller::get_instance(
            'PUT',
            ['update' => 'order'],
            $body
        );



        $json_response = $this->session_controller->get_json_response();

        $object = json_decode($json_response);

        $this->assertEquals(14, $object->session->order->items[0]->quantity);
    }


}