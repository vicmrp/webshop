<?php
use \PHPUnit\Framework\TestCase;
use vezit\repositories\product_repository\Product_Repository;
use vezit\repositories\super_repository\Super_Repository;
use vezit\dto\endpoints\get_products\response\Get_Products_Response;
use vezit\classes\mysqli\Mysqli;
use vezit\services\product_service\Product_Service;

require __DIR__ . '/../global-requirements.php';


class Product_Service_Test extends TestCase
{
    protected function setUp() : void
    {
        $this->product_service = Product_Service::get_instance(new Product_Repository(new Super_Repository(new Mysqli('localhost', 'test', 'Passw0rd', 'test_user_v6_vezit_webshop'))));
    }

    // ------- Read -------
    /** @test */
    public function get_all__shall_return_correct_type() {
        $this->assertInstanceOf(Get_Products_Response::class, $this->product_service->get_all());
    }

    /** @test */
    public function get_all__shall_return_data_from_database() {
        $get_products_response = $this->product_service->get_all();
        $book1 = $get_products_response->get()[4];
        $this->assertEquals("Steen's Karriere", $book1->name);
    }
}