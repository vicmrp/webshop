<?php

namespace vezit\services\product_service;

require __DIR__.'/../../global-requirements.php';

use vezit\dto\product\response as Product_Response;
use vezit\repositories\product_repository as Product_Repository;

class Product_Service {

  public function get_all() : Product_Response\List_Of_Products_Response
  {
    $product_repository = new Product_Repository\Product_Repository();
    $products = $product_repository->get_all();

    $list_of_products_response = new Product_Response\List_Of_Products_Response();
    foreach($products->list_of_products as $e) {
      $product_response = new Product_Response\Product_Response();
      $product_response->id       = $e->id;
      $product_response->name     = $e->name;
      $product_response->price    = $e->price;
      $product_response->quantity = $e->quantity;
      array_push($list_of_products_response->list_of_products, $product_response);
    }
    return $list_of_products_response;
  }

  public function get_by_id(int $id) : Product_Response\Product_Response {

    $product_repository = new Product_Repository\Product_Repository();

    $repository_reponse = $product_repository->find($id);

    $product_response = new Product_Response\Product_Response();
    $product_response->id = $repository_reponse->id;
    $product_response->name = $repository_reponse->name;
    $product_response->price = $repository_reponse->price;
    $product_response->quantity = $repository_reponse->quantity;

    return $product_response;

  }
}
