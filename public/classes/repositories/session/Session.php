<?php
namespace vezit\classes\repositories\session;

require __DIR__.'/../../../global-requirements.php';

class Session implements ISession {


  public function find(string $session_id) : object
  {
    return json_decode(file_get_contents(_from_top_folder()."/temp_database/session/$session_id.json"));
  }


  public function insert(object $session) : void
  {
    $session_id = $session->get_session_id();
    file_put_contents(_from_top_folder()."/temp_database/session/$session_id.json", json_encode($session, JSON_PRETTY_PRINT));
  }


  public function update(string $session_id, object $payment) : void
  {

    if($payment->accepted)
    {
      $json = file_get_contents(_from_top_folder()."/temp_database/session/$session_id.json");

      $session = json_decode($json);
      $session->order->order_status->payment->accepted = true;

      $json = json_encode($session, JSON_PRETTY_PRINT);

      unlink(_from_top_folder()."/temp_database/session/$session_id.json");

      file_put_contents(_from_top_folder()."/temp_database/session/$session_id.json", $json);
    }

    // if entity has accepted move to accepted

    // $accepted = 

  }


  public function delete(object $entity) : void
  {

  }

  
}