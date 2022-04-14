<?php 

require_once __DIR__.'/../global-requirements.php';

use vezit\services\session_service\Session_Service;
use vezit\dto\session\response\Session_Response;
use vezit\classes\session\Session;

class Session_Service_Test extends \PHPUnit\Framework\TestCase
{
  protected $session_service;

  protected function setUp(): void 
  {
    $this->session_service = new Session_Service();
    $this->session = new Session();

  }


  
  /** @test */
  public function check_that__get_session__if_correct_type_is_returned()
  {
    $this->assertInstanceOf(Session_Response::class, $this->session_service->get_session());
  }





  /** @test */
  public function check_that__add_order_item__returns_expected_type() {
    $this->assertInstanceOf(Session_Response::class, $this->session_service->add_order_item(1,2));
  }



  
  // /** @test */
  // public function check_that__remove_order_item__returns_expected_type() {
    


  //   $mock_repo = $this->createMock(Session::class);

  //   // $mock_repo->expects($this->once());

  //   $mock_repo->method('order->remove_order_item')->willReturn(true);


  //   $this->assertInstanceOf(Session_Response::class, $this->session_service->remove_order_item(1));
  // }


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
