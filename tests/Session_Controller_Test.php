<?php
use \PHPUnit\Framework\TestCase;
use vezit\controllers\session_controller\Session_Controller;
use vezit\dto\Session_Order_Update_Request;
use vezit\dto\Session_Order_Update_Requests;

require __DIR__ . '/../global-requirements.php';

/**
 * There should be one operation for each test.
 * There can as many assertions as you want.
 */

class Session_Controller_Test extends TestCase
{
    protected function setUp() : void
    {


        $this->body = '{
            "customer": {
                "fullname": "Victor Reipur",
                "address": {
                    "street": "Vinkelvej",
                    "postal_code": "2800",
                    "city": "Lyngby"
                },
                "contact": {
                    "phone": "26129604",
                    "email": "victor.reipur@gmail.com"
                },
                "company": {
                    "cvr_number": null,
                    "company_name": null
                }
            }
        }';

        $this->session_controller = Session_Controller::get_instance(
            $request_method = 'GET'
            ,$url_parameters = [
                'query' => urlencode('')
                ]

        );
    }

    protected function tearDown(): void
    {

    }


    // --------- GET --------- //
    /** @test */
    public function get_json_response__proof_that_you_get_a_session() {

        Session_Controller::destroy_instance();
        $this->session_controller = Session_Controller::get_instance(
            $request_method = 'GET'
            ,$url_parameters = [
                'query'  => urlencode('get-session')
            ]
        );

        $json       = $this->session_controller->get_json_response();
        $session    = json_decode($json);

        $this->assertTrue(isset($session));

    }


    /** @test
     * This test should respond when a failure because customer details has not been satisfied
     */
    public function get_json_response__get_payment_link() {

        // Setup
        Session_Controller::destroy_instance();
        $this->session_controller = Session_Controller::get_instance(
            $request_method = 'GET'
            ,$url_parameters = [
                'query'  => urlencode('get-session')
            ]
        );



        // Expects failure, because customer details has not been satisfied


        // Add customer details

        // Expects failure, because shipment details has not been satisfied

        // Add shipment details

        // Expects failure, because payment details has not been satisfied

        // Add payment details

        // It should be possible to get a payment link now


        $this->assertTrue(true);
    }
    // --------- GET --------- //












    // --------- PUT --------- //
    /** @test */
    public function get_json_response__update_customer() {


        Session_Controller::destroy_instance();
        $this->session_controller = Session_Controller::get_instance(
            $request_method = 'PUT'
            ,$url_parameters = [
                'query'  => urlencode('update-customer')
                ]
            ,$body = $this->body
        );

        $json = $this->session_controller->get_json_response();
        $updated_session = json_decode($json);
        $fullname = $updated_session->session->customer->fullname;

        $this->assertEquals("Victor Reipur", $fullname);

    }


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
            $request_method     = 'PUT'
            ,$url_parameters    = ['query' => 'update-order-items']
            ,$body              = $body
        );



        $json_response = $this->session_controller->get_json_response();

        $object = json_decode($json_response);

        $this->assertEquals(14, $object->session->order->items[0]->quantity);
    }




    public function get_json_response__update_shipment() {

    }
    // --------- PUT --------- //



    // --------- DELETE --------- //
    /** @test */
    public function get_json_response__proof_that_you_can_destroy_a_session() {
        Session_Controller::destroy_instance();
        $this->session_controller = Session_Controller::get_instance(
            $request_method = 'GET'
            ,$url_parameters = [
                'query'  => urlencode('delete-session')
            ]
        );

        $session_delete_response = json_decode($this->session_controller->get_json_response(), JSON_PRETTY_PRINT);


        $this->assertEquals(true, $session_delete_response->session_has_been_unset);
    }
    // --------- DELETE --------- //


}