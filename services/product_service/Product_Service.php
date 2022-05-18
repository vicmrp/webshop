<?php namespace vezit\services\product_service;
require __DIR__ . '/../../global-requirements.php';
use vezit\repositories\product_repository\Product_Repository;
use vezit\dto\endpoints\get_product\response\Get_Product_Response;
use vezit\dto\endpoints\get_products\response\Get_Products_Response;
use vezit\dto\internal_dtos\product\Product;
use vezit\dto\internal_dtos\products\Products;

require __DIR__ . '/../../global-requirements.php';

class Product_Service
{
    private static $_instance = null;
    private Product_Repository $_product_repository;

    private function __construct(Product_Repository $product_repository)
    {
        $this->_product_repository = $product_repository;
    }

    public static function get_instance(Product_Repository $product_repository = new Product_Repository())
    {

      if (self::$_instance == null)
      {
        self::$_instance = new Product_Service($product_repository);
      }



      return self::$_instance;
    }


    public function get_all() : Get_Products_Response {

        $products_model = $this->_product_repository->get_all()->get();
        $array_of_products = [];
        foreach($products_model as $pk => $entity) {
            $product = new Product(
                $entity->product_pk,
                $entity->datetime_created,
                $entity->datetime_last_modified,
                $entity->name,
                $entity->price,
                $entity->quantity
            );
            $array_of_products += [$entity->product_pk => $product];
        }

        $get_products_response = new Get_Products_Response();
        $products = new Products;
        $products->set($array_of_products);
        $get_products_response->set($products);
        return $get_products_response;
    }



}
