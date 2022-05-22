<?php
use \PHPUnit\Framework\TestCase;
use vezit\services\product_service\Product_Service;
use vezit\repositories\product_repository\Product_Repository;
use vezit\classes\mysqli\Mysqli;
use vezit\controllers\product_controller\Product_Controller;
use vezit\repositories\super_repository\Super_Repository;
use vezit\dto\Product_Response;
use vezit\entities\Product;

require __DIR__ . '/../global-requirements.php';

class Product_Controller_Test extends TestCase
{
    protected function setUp() : void
    {
        $this->product_controller = new Product_Controller(
            'GET',
            Product_Service::get_instance((new Product_Repository(new Super_Repository(new Mysqli('localhost', 'test', 'Passw0rd', 'test_user_v6_vezit_webshop')))))
        );
    }

    protected function tearDown(): void
    {

    }


    /** @test */
    public function get_json_response__return_array_of_products() {



        Product_Service::delete_instance();

        // Setup
        $pk_3 = 3;
        $pk_4 = 4;
        $mock_dto_array = [
            new Product_Response(
                $pk_3,
                "Harry Potter",
                25000,
                1
            ),
            new Product_Response(
                $pk_4,
                "The Lord of the Rings",
                50000,
                2
            )
        ];

        $mock_product_service = $this->createMock(Product_Service::class);
        $mock_product_service->method('get_all')->willReturn($mock_dto_array);

        $product_controller = new Product_Controller('GET', $mock_product_service);


        $json_of_products = $product_controller->get_json_response();

        $products = json_decode($json_of_products, false);

        $this->assertEquals("Harry Potter", $products[0]->name);
        $this->assertEquals("The Lord of the Rings", $products[1]->name);
    }


}
