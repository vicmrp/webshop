<?php
use \PHPUnit\Framework\TestCase;
use vezit\repositories\product_repository\Product_Repository;
use vezit\repositories\super_repository\Super_Repository;
use vezit\dto\Product_Response;
use vezit\classes\mysqli\Mysqli;
use vezit\entities\Product;
use vezit\entities\Products;
use vezit\services\product_service\Product_Service;

require __DIR__ . '/../global-requirements.php';


class Product_Service_Test extends TestCase
{
    protected function setUp() : void
    {
        $this->product_service = Product_Service::get_instance(new Product_Repository(new Super_Repository(new Mysqli('localhost', 'test', 'Passw0rd', 'test_user_v6_vezit_webshop'))));
    }

    protected function tearDown(): void
    {

    }


    // ------- Read -------
    /** @test */
    public function get_all__shall_return_correct_type() {
        $products = $this->product_service->get_all();
        $product = $products[array_key_first($products)];

        $this->assertInstanceOf(Product_Response::class, $product);
    }

    /** @test */
    public function get_all__shall_return_data_from_database() {


        // Setup
        Product_Service::delete_instance();

        $pk = 1;
        $mock_entity_products = new Products();
        $mock_entity_product = new Product(
            $pk,
            null,
            null,
            "Harry Potter",
            50000,
            2
        );
        $mock_entity_products->set([$pk => $mock_entity_product]);

        $mock_product_repository = $this->createMock(Product_Repository::class);
        $mock_product_repository->method('get_all')->willReturn($mock_entity_products);

        $product_service = Product_Service::get_instance($mock_product_repository);


        $products = $product_service->get_all();
        $this->assertEquals("Harry Potter", $products[0]->name);
    }
}