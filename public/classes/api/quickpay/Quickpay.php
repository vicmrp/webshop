<?php
namespace vezit\classes\api\quickpay;
require_once __DIR__.'/../../../global-requirements.php';

class Quickpay
{
  private static $newpayment;
  private static $payment_id;

  public function __construct() {
  }

  public static function get_helloworld()
  {
    return "Hello World from static quickpay";
  }

    // 1. Create a new payment
  // https://learn.quickpay.net/tech-talk/guides/payments/#create-a-new-payment
  // -------------------------------------------------------------------------- //
  public function set_newpayment(string $order_id) {
    global $g_quickpay_apikey;

    $url = 'https://api.quickpay.net/payments';
    $apikey = $g_quickpay_apikey;
    $create_newpayment_json_response = shell_exec("curl -u ':$apikey' -H 'content-type:application/json' -H 'Accept-Version:v10' -X POST -d '{\"order_id\":\"$order_id\",\"currency\":\"dkk\"}' $url 2> /dev/null");
    return json_decode($create_newpayment_json_response);
  }
  // -------------------------------------------------------------------------- //




  // 2. Authorize payment using a link
  // https://learn.quickpay.net/tech-talk/guides/payments
  // -------------------------------------------------------------------------- //
  public static function create_paymentlink(string $order_id, int $price) {
    global $g_quickpay_apikey;

    $apikey = $g_quickpay_apikey;

    $id = $this->payment->id;
    $url = "https://api.quickpay.net/payments/$id/link";
    $paymentlink = 
    shell_exec("curl -u ':$apikey' -H 'content-type:application/json' -H 'Accept-Version:v10' -X PUT -d '{\"amount\":\"$price\"}' $url 2> /dev/null");
    $this->paymentlink = json_decode($paymentlink);
  }

  public static function get_paymentlink() {
    return $this->paymentlink->url;
  }
  // -------------------------------------------------------------------------- //




  // // 3. Check payment status
  // // -------------------------------------------------------------------------- //
  // public static function set_paymentstatus()
  // {
  //   $id = $this->payment->id;
  //   $apikey = $this->apikey;
  //   $url = "https://api.quickpay.net/payments/$id";
  //   $paymentstatus = 
  //   shell_exec("curl -u ':$apikey' -H 'content-type:application/json' -H 'Accept-Version:v10' -X GET $url 2> /dev/null");
  //   $this->payment = json_decode($paymentstatus);
  // }

  // public function get_paymentstatus() {
  //   return $this->payment;
  // }
  // // -------------------------------------------------------------------------- //



  // // Callback
  // // -------------------------------------------------------------------------- //
  // public static function get_callback($request_body, $privateKey) {

  //   function sign($base, $private_key) {
  //     return hash_hmac("sha256", $base, $private_key);
  //   }
    
  //   $checksum     = sign($request_body, $privateKey);    
    
  //   if ($checksum == $_SERVER["HTTP_QUICKPAY_CHECKSUM_SHA256"]) {
  //     // Handter betaling
  //     return $request_body;
  //     // Hvis betalingen er gennemført sa gem ordre og lokation samt send email til køber
      
  //     // Request is authenticated
    
  //     // Hent info om varerordren og put den i en fil kaldet varenummeret, herefter vedhæft filen til mailen.
    
  //   }
  // }
  // // -------------------------------------------------------------------------- //
}
