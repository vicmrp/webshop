<?php
namespace vezit\classes\api\quickpay;

class Quickpay
{
  private $apikey;
  public $price = '';
  public $order_id;
  private $paymentlink;

  public function __construct(string $apikey) {
    $this->apikey = $apikey;
  } 

  
  public function set_paymentlink($price, $order_id)
  {

  }

  public function get_paymentlink()
  {
    $order_id = $this->order_id
    $get_paymentlink = shell_exec("curl -u ':$apiKey' -H 'content-type:application/json' -H 'Accept-Version:v10' -X POST -d '{\"order_id\":\"$order_id\",\"currency\":\"dkk\"}' https://api.quickpay.net/payments 2> /dev/null");
    $get_paymentlink = json_decode($createPaymentResponse);
  }

  // public function get_apikey()
  // {
  //   return $this->apikey;
  // }
}
