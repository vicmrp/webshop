<?php
namespace vezit\classes\api;

require_once __DIR__.'/../../global-requirements.php';

use vezit\classes\api\quickpay as Quickpay;

class Api
{
  public $quickpay;
  public $postnord;
  public $dawa;

  public function __construct() {
    $this->quickpay = new Quickpay\Quickpay();
  }
}
