<?php

namespace vezit\services\session_service;

use vezit\classes\session as Session;
use vezit\dto\session\response as Session_Response;
use vezit\classes\session\order\order_item as Order_Item;
use vezit\services\product_service as Product_Service;
require __DIR__.'/../../global-requirements.php';

class Session_Service
{
  private $session;

  public function __construct()
  {
    $this->session = new Session\Session();
  }

  public function add_order_item(int $product_id, int $new_quantity) : Session_Response\Session_Response {
    
    // find item in database
    $product_service = new Product_Service\Product_Service();
    $product_reponse = $product_service->get_by_id($product_id);


    // is item already added to object?
    if ($this->session->order->get_order_item($product_id)->order_item === null) {
      $new_order_item = new Order_Item\Order_Item($product_reponse->name, $product_reponse->id, $product_reponse->price, $new_quantity);
      $this->session->order->add_order_item($new_order_item);
    } else {
      $this->session->order->set_change_quantity_order_item($product_id, $new_quantity);
    }
    return $this->get_session();
  }


  public function get_session() : Session_Response\Session_Response {
    $session_response = new Session_Response\Session_Response();    
    $session_response->session = $this->session;    
    return $session_response;
  }
}
