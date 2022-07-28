<?php
use vezit\dto\class\session\order\item\Item;
use vezit\dto\Session_Response;
use vezit\services\session_service\Session_Service;
use \PHPUnit\Framework\TestCase;
use vezit\dto\Session_Order_Update_Request;
use vezit\dto\Session_Order_Update_Requests;

require __DIR__ . '/../global-requirements.php';

class Session_Service_Test extends TestCase {

    protected function setUp() : void
    {



        $this->session_service = Session_Service::get_instance();



    }

    protected function tearDown() : void
    {
    }



    /** @test */
    public function update_customer__shall_update_customer() {
        $body = '{
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

        $result = $this->session_service->update_customer(json_decode($body));

        $this->assertEquals("Victor Reipur", $result->customer->fullname);

        // Check om du kan fa create_payment til at virke i en unit test.
        // payment_details skal vaere tilfredsstillet.
        // nar quickpay skal lave et payment link sa kraever det at

    }


    // /** @test
    //  *  @depends update_customer__shall_update_customer
    //  */
    // public function update_order__shall_update_customer() {

    // }




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
    public function update_order__get_response()
    {

        $json = '
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


        $array_result = [];
        $array_incoming_data = json_decode($json);
        foreach ($array_incoming_data as $object) {
            array_push($array_result, g_generate_flat_dto_from_web_request($object, Session_Order_Update_Request::class));
        }

        $session_order_update_requests = new Session_Order_Update_Requests;

        $session_order_update_requests->set($array_result);

        $session_response = $this->session_service->update_order($session_order_update_requests);

        $this->assertEquals(14, $session_response->session->order->get_items()[0]->quantity);

    }

}
