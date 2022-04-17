<?php
require __DIR__ . '/../global-requirements.php';

use vezit\dto\session\response\Session_Response;
use vezit\classes\session\Session;
use vezit\services\login_service\Login_Service;
use vezit\services\session_service\Session_Service;
use vezit\repositories\user_repository\User_Repository;
use vezit\dto\login\request\Login_Request;
use \PHPUnit\Framework\TestCase;
use vezit\dto\product\response\Product_Response;
use vezit\services\product_service\Product_Service;

class Session_Service_Test extends TestCase {
    protected function setUp() : void
    {
        $this->session_service = new Session_Service(new Session, new Product_Service);
    }

    protected function tearDown() : void
    {
        $this->session_service = null;
    }


    /** @test */
    public function set_customer_shall_return_correct_instance_of_class()
    {
        $customer_info_from_database =
            array(
            'fullname'=>'Victor Reipur',
            'phone'=>'26129604',
            'email'=>'victor.reipur@gmail.com',
            'street'=>'vinkelvej 12d, 3tv',
            'postal_code'=>'2800',
            'city'=>'Lyngby',
            'cvr_number'=>null,
            'company_name'=>null
            );

        $session_response = $this->session_service->set_customer_info_from_database($customer_info_from_database);
        $this->assertInstanceOf(Session_Response::class, $session_response);
    }


    /** @test */
    public function remove_order_item_from_session_shall_return_correct_instance_of_class_using_mock()
    {


        // Setup
        $mock_product_response = new Product_Response;
        $mock_product_response->id = 1;
        $mock_product_response->name = 'Test Product';
        $mock_product_response->price = 100;
        $mock_product_response->description = 'Test Product Description';

        $mock_product_service = $this->createMock(Product_Service::class);
        $mock_product_service->method('get_product_by_id')->willReturn($mock_product_response);




        // Do something

        // Assert



        $session_response = $this->session_service->remove_order_item_from_session(1);
        $this->assertInstanceOf(Session_Response::class, $session_response);
    }
}