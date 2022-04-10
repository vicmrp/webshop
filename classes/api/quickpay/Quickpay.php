<?php
namespace vezit\classes\api\quickpay;
require_once __DIR__.'/../../../global-requirements.php';

class Quickpay
{
  private $payment;
  private $paymentlink;

  public function __construct()
  {

  }

  public function get_payment()
  {
    return $this->payment;
  }

  public function get_paymentlink()
  {
    return $this->paymentlink;
  }


  // 1. Create a new payment
  // https://learn.quickpay.net/tech-talk/guides/payments/#create-a-new-payment
  // -------------------------------------------------------------------------- //
  public function call_create_payment(string $order_id) : object {
    global $g_quickpay_apikey;

    $url = 'https://api.quickpay.net/payments';
    $apikey = $g_quickpay_apikey;
    $create_newpayment_json_response = shell_exec("curl -u ':$apikey' -H 'content-type:application/json' -H 'Accept-Version:v10' -X POST -d '{\"order_id\":\"$order_id\",\"currency\":\"dkk\"}' $url 2> /dev/null");
    return json_decode($create_newpayment_json_response);
    // echo "<pre>" . json_encode($create_newpayment_json_response , JSON_PRETTY_PRINT) . "</pre>"; die();
  }
  // -------------------------------------------------------------------------- //




  // 2. Authorize payment using a link
  // https://learn.quickpay.net/tech-talk/guides/payments
  // -------------------------------------------------------------------------- //
  public function call_create_or_update_paymentlink(string $id, string $price) {
    
    global $g_quickpay_apikey;
    $apikey = $g_quickpay_apikey;    
    $id = urlencode($id);
    $price = urlencode($price);
    $url = "https://api.quickpay.net/payments/$id/link";
    $paymentlink = 
    shell_exec("curl -u ':$apikey' -H 'content-type:application/json' -H 'Accept-Version:v10' -X PUT -d '{\"amount\":\"$price\"}' $url 2> /dev/null");
    
    return json_decode($paymentlink);
  }
  // -------------------------------------------------------------------------- //




  // 3. Check payment status
  // -------------------------------------------------------------------------- //
  public function call_get_payments() : object
  {
    global $g_quickpay_apikey;
    $apikey = $g_quickpay_apikey;
    $url = "https://api.quickpay.net/payments";
    $paymentstatus =
    shell_exec("curl -u ':$apikey' -H 'content-type:application/json' -H 'Accept-Version:v10' -X GET $url 2> /dev/null");
    return (object)json_decode($paymentstatus, false);
  }
  // -------------------------------------------------------------------------- //


  public function call_get_payment_by_id(int $id) : object {
    global $g_quickpay_apikey;
    $apikey = $g_quickpay_apikey;
    $url = "https://api.quickpay.net/payments/$id";
    $paymentstatus =
    shell_exec("curl -u ':$apikey' -H 'content-type:application/json' -H 'Accept-Version:v10' -X GET $url 2> /dev/null");
    return (object)json_decode($paymentstatus, false);
  }
  

  // Callback - en automatisk udgave af call_get_paymentstatus
  // quickpay kalder denne funktion nar en betaling er gennemført 
  // gemmer resultat i 
  // -------------------------------------------------------------------------- //
  public function validate($request_body) : bool {
    global $g_quickpay_privatekey;

    function sign($base, $private_key) {
      return hash_hmac("sha256", $base, $private_key);
    }
    
    $checksum     = sign($request_body, $g_quickpay_privatekey);    
    
    if ($checksum == $_SERVER["HTTP_QUICKPAY_CHECKSUM_SHA256"]) {
      $this->payment = json_decode($request_body);
      return true;
    }
    return false;
  }
  // -------------------------------------------------------------------------- //
}
