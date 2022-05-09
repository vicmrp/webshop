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
        $this->product_repository = new Product_Repository(
            new Super_Repository(new Mysqli('localhost', 'test', 'Passw0rd', 'test_user_v6_vezit_webshop'))
        );
    }

    /** @test */
    public function get_all__shall_return_array_of_product_entities()
    {
        $products =  $this->product_repository->get_all();


        // Assert
        foreach ($products->get_products() as $product) {
            if (!($product instanceof Product)) {
                $this->fail('Product_Repository::get_all() shall return an array of Product objects');
            }
        }


        $this->assertInstanceOf(Products::class, $products);

    }


    /** @test */
    public function get_by_pk__should_return_correct_object()
    {
        (object)$products =  $this->product_repository->get_all();

        (array)$collection_of_products = $products->get_products();

        (object)$first_product_in_collection = $collection_of_products[array_key_first($products->get_products())];

        (int)$product_pk = $first_product_in_collection->product_pk;

        $product = $this->product_repository->get_by_pk($product_pk);

        $this->assertInstanceOf(Product::class, $product);
        $this->assertEquals($product_pk, $product->product_pk);
    }



    /** @test */
    public function update__should_confirm_that_product_is_update() {
        (object)$products =  $this->product_repository->get_all();

        (array)$collection_of_products = $products->get_products();

        (object)$first_product_in_collection = $collection_of_products[array_key_first($products->get_products())];

        (int)$product_pk = $first_product_in_collection->product_pk;


        $old_name_for_product = $first_product_in_collection->name;
        $new_name_for_product = 'New name for product';
        $first_product_in_collection->name = $new_name_for_product;

        $this->product_repository->update($product_pk, $first_product_in_collection);

        $updated_product = $this->product_repository->get_by_pk($product_pk);

        // Confirm no side effects
        $this->assertEquals($first_product_in_collection->product_pk, $updated_product->product_pk);
        $this->assertEquals($first_product_in_collection->name, $updated_product->name);
        $this->assertEquals($first_product_in_collection->price, $updated_product->price);
        $this->assertEquals($first_product_in_collection->quantity, $updated_product->quantity);

        // confirm name is updated
        $this->assertEquals($new_name_for_product, $updated_product->name);

        // reset
        $updated_product->name = $old_name_for_product;
        $this->product_repository->update($updated_product->product_pk, $updated_product);


    }
}