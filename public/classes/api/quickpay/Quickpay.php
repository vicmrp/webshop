<?php
namespace vezit\classes\api\quickpay;

class Quickpay
{
  private $apikey;
  private $price;
  private $order_id;
  private $payment;
  private $paymentlink;


  public function __construct() {
    $this->apikey = $apikey;
    $this->order_id = $order_id;
  }




  // 1. Create a new payment
  // https://learn.quickpay.net/tech-talk/guides/payments/#create-a-new-payment
  // -------------------------------------------------------------------------- //
  public function set_payment() {
    $url = 'https://api.quickpay.net/payments';
    $apikey = $this->apikey;
    $order_id = $this->order_id;
    $payment = 
    shell_exec("curl -u ':$apikey' -H 'content-type:application/json' -H 'Accept-Version:v10' -X POST -d '{\"order_id\":\"$order_id\",\"currency\":\"dkk\"}' $url 2> /dev/null");
    $payment = json_decode($payment);
    $this->payment = $payment;
  }

  public function get_payment() {
    return $this->payment;
  }
  // -------------------------------------------------------------------------- //




  // 2. Authorize payment using a link
  // https://learn.quickpay.net/tech-talk/guides/payments
  // -------------------------------------------------------------------------- //
  public function set_paymentlink($price)
  {
    
    $apikey = $this->apikey;
    $order_id = $this->order_id;
    $id = $this->payment->id;
    $url = "https://api.quickpay.net/payments/$id/link";
    $paymentlink = 
    shell_exec("curl -u ':$apikey' -H 'content-type:application/json' -H 'Accept-Version:v10' -X PUT -d '{\"amount\":\"$price\"}' $url 2> /dev/null");
    $this->paymentlink = json_decode($paymentlink);
  }

  public function get_paymentlink() {
    return $this->paymentlink->url;
  }
  // -------------------------------------------------------------------------- //




  // 3. Check payment status
  // -------------------------------------------------------------------------- //
  public function set_paymentstatus()
  {
    $id = $this->payment->id;
    $apikey = $this->apikey;
    $url = "https://api.quickpay.net/payments/$id";
    $paymentstatus = 
    shell_exec("curl -u ':$apikey' -H 'content-type:application/json' -H 'Accept-Version:v10' -X GET $url 2> /dev/null");
    $this->payment = json_decode($paymentstatus);
  }

  public function get_paymentstatus() {
    return $this->payment;
  }
  // -------------------------------------------------------------------------- //


  // Callback
  // -------------------------------------------------------------------------- //

  public static function callback($request_body, $privateKey) {

    function sign($base, $private_key) {
      return hash_hmac("sha256", $base, $private_key);
    }
    
    $checksum     = sign($request_body, $privateKey);    
    
    if ($checksum == $_SERVER["HTTP_QUICKPAY_CHECKSUM_SHA256"]) {
      // Handter betaling
      return $request_body;
      // Hvis betalingen er gennemført sa gem ordre og lokation samt send email til køber
      
      // Request is authenticated
    
      // Hent info om varerordren og put den i en fil kaldet varenummeret, herefter vedhæft filen til mailen.
    
    }
  }
  // -------------------------------------------------------------------------- //
}