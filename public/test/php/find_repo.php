<?php 
// ----- global ----- //
require_once __DIR__.'/../../global-requirements.php'; // _from_top_folder().

use vezit\classes\repositories\product as R_Product;
use vezit\classes\session as Session;
$session = new Session\Session();

// add order item to session



function add_order_item($product_id, $quantity = null) : object
{
  // Get item from products
  $r_product = new R_Product\Product;
  $product = $r_product->find($product_id);
  return $product;
}

// Retuner 
/*
{
  "product_name": "kabelsamler",
  "product_id": "2312314",
  "price": 1000,
  "quantity": 14
}

  echo json_encode($product, JSON_PRETTY_PRINT);
  $session->order->add_order_item($product);
  
*/
$session->order->add_order_item(add_order_item("2312314", 5));

echo json_encode($session, JSON_PRETTY_PRINT);
