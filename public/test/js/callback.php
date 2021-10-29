<?php 

// /sleep.php?sleep=4&msg=HelloWorld
$sleep = isset($_GET["sleep"]) ? $_GET['sleep'] : 0;
$msg = isset($_GET["msg"]) ? $_GET['msg'] : 'No message specified';

// sov i angivet sekunder
sleep($sleep);

// skriv besked
class JsonResponse {
  public $msg;

  public function __construct($msg) 
  {
    $this->msg = $msg;
  }
}

$jsonResponse = new JsonResponse($msg);

echo json_encode($jsonResponse);
