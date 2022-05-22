<?php
use \PHPUnit\Framework\TestCase;
use vezit\controllers\session_controller\Session_Controller;


require __DIR__ . '/../global-requirements.php';

class Session_Controller_Test extends TestCase
{
    protected function setUp() : void
    {
    }

    protected function tearDown(): void
    {
    }

    /** @test */
    public function get_json_response__get_session() {

        $session_controller = new Session_Controller(
            'GET'
        );

        $json = $session_controller->get_json_response();
        $session = json_decode($json);

        $this->assertTrue(isset($session));

    }


    /** @test */
    public function get_json_response__update_customer() {

        $body = file_get_contents(__DIR__ . '/json/Session_Controller_Test_Update_Body.json');

        $session_controller = new Session_Controller(
            'PUT',
            ['update' => 'customer'],
            $body,
            null
        );

        $json = $session_controller->get_json_response();
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


}