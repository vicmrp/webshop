<?php
use \PHPUnit\Framework\TestCase;
use vezit\entities\Product;
use vezit\entities\Products;
use vezit\repositories\product_repository\Product_Repository;
use vezit\classes\mysqli\Mysqli;
use vezit\repositories\super_repository\Super_Repository;
require __DIR__ . '/../global-requirements.php';



class Product_Repository_Test extends TestCase
{
    protected function setUp() : void
    {
        $this->product_repository = new Product_Repository(new Super_Repository(new Mysqli('localhost', 'test', 'Passw0rd', 'test_user_v6_vezit_webshop')));
    }

    /** @test */
    public function get_all__shall_return_array_of_product_entities()
    {
        $products = $this->product_repository->get_all();


        // Assert
        foreach ($products->get() as $product) {
            if (!($product instanceof Product)) {
                $this->fail('Product_Repository::get_all() shall return an array of Product objects');
            }
        }


        $this->assertInstanceOf(Products::class, $products);

    }


    /** @test */
    public function get_by_pk__should_return_correct_object()
    {
        // Setup
        $products = $this->product_repository->get_all();

        (int)$first_array_key = array_key_first($products->get());

        $first_product_object_in_collection = $products->get()[$first_array_key];

        // Act
        $response_product = $this->product_repository->get_by_pk($first_product_object_in_collection->product_pk);

        // Assert
        $this->assertInstanceOf(Product::class, $response_product);
        $this->assertEquals($first_array_key, $response_product->product_pk);
    }



    /** @test */
    public function update__should_confirm_that_product_is_update() {
        // Setup
        $products = $this->product_repository->get_all();

        (int)$first_array_key = array_key_first($products->get());

        $first_product_object_in_collection = $products->get()[$first_array_key];

        // Act
        $pk = $first_product_object_in_collection->product_pk;
        $first_product_object_in_collection->price = rand(10000, 100000);
        $first_product_object_in_collection->quantity = rand(100, 1000);


        $has_been_updated = $this->product_repository->update($pk, $first_product_object_in_collection);
        $updated_product = $this->product_repository->get_by_pk($pk);


        $this->assertTrue($has_been_updated);
        $this->assertEquals($first_product_object_in_collection->price, $updated_product->price);
        $this->assertEquals($first_product_object_in_collection->quantity, $updated_product->quantity);
    }
}