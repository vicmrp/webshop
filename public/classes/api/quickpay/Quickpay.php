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
    // $this->apikey = $apikey;
    // $this->order_id = $order_id;
  }


  // Callback
  // -------------------------------------------------------------------------- //
  public static function get_callback($request_body, $privateKey) {

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
