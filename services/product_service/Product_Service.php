<?php namespace vezit\services\product_service;
require __DIR__ . '/../../global-requirements.php';
use vezit\repositories\product_repository\Product_Repository;
use vezit\dto\Product_Response;

require __DIR__ . '/../../global-requirements.php';

class Product_Service
{
    private static $_instance = null;
    private Product_Repository $_product_repository;

    private function __construct(Product_Repository $product_repository)
    {
        $this->_product_repository = $product_repository;
    }

    public static function get_instance(Product_Repository $product_repository = new Product_Repository)
    {

      if (self::$_instance == null)
      {
        self::$_instance = new Product_Service($product_repository);
      }

      return self::$_instance;
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
            $array_of_products += [$product];
        }

        return $array_of_products;
    }

    public static function delete_instance() {
        self::$_instance = null;
    }

}
