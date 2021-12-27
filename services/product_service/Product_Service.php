<?php

namespace vezit\services\product_service;

require __DIR__.'/../../global-requirements.php';

use vezit\dto\product\response as Product_Response;
use vezit\repositories\product_repository as Product_Repository;

class Product_Service
{
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
