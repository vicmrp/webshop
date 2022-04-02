<?php 

require_once __DIR__.'/../global-requirements.php';

use vezit\services\session_service\Session_Service;
use vezit\dto\session\response\Session_Response;

class SessionServiceTest extends \PHPUnit\Framework\TestCase
{
  // private $session_service;

  // public function __construct()
  // {
  //   $this->session_service = new Session_Service();
  // }
  
  /** @test */
  public function check_get_session_that_correct_type_is_returned()
  {
    $session_service = new Session_Service();
    $this->assertInstanceOf(Session_Response::class, $session_service->get_session());
    // $session_service->session = null;
  }


  /** @test */
  public function check_that_add_order_item_returns_expected_type() {
    $session_service = new Session_Service();
    $this->assertInstanceOf(Session_Response::class, $session_service->add_order_item(1,2));
    // $session_service->session = null;
  }
  

  // public function test_that_add_order_item_returns_correct_items()
  // {

  //   $session_service = new Session_Service();
  //   $session_response = $session_service->add_order_item(1,2);

  //   $this->assertEquals(1, $session_response->session->order->order_items[0]->product_id);
  //   $this->assertEquals(2, $session_response->session->order->order_items[0]->quantity);
    
    
  //   // find value in array
  //   // search value in array



  //   // $response = $session_service->add_order_item(1,2)

  //   // $this->assertEquals()
  //   // $this->assertInstanceOf(Session_Response::class, );
  // }
}
