<?php namespace vezit\services\product_service;
require __DIR__ . '/../../global-requirements.php';
use vezit\repositories\product_repository\Product_Repository;
use vezit\dto\Product_Response;

require __DIR__ . '/../../global-requirements.php';

class Product_Service
{
    private static $_times_instantiated = 0;
    private static $_instance = null;


    public static function get_instance(Product_Repository $product_repository = null)
    {

        return (self::$_instance === null) ? new Product_Service(

            (null === $product_repository) ? Product_Repository::get_instance() : $product_repository

        ) : self::$_instance;

    }



    private function __construct(private Product_Repository $_product_repository)
    {
        self::$_times_instantiated++;
    }


    public function get_all() : array {

        $products_model = $this->_product_repository->get_all()->get();
        $array_of_products = [];
        foreach($products_model as $pk => $entity) {
            $product = new Product_Response(
                $entity->product_pk,
                $entity->name,
                $entity->price,
                $entity->quantity
            );
            array_push($array_of_products,$product);
        }

        return $array_of_products;
    }

    public static function delete_instance() {
        self::$_instance = null;
    }

}
