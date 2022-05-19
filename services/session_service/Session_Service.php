<?php namespace vezit\services\session_service;
use vezit\models\session\Session;
use vezit\dto\Session_Response;
use vezit\dto\Session_Delete_Response;
use vezit\repositories\session_repository\Session_Repository;
use vezit\entities\session\Session_Entity;

require __DIR__ . '/../../global-requirements.php';

class Session_Service
{
    private static $_instance = null;
    private Session_Repository $_session_Repository;
    private Session_Response $_session_response;







    private function __construct(Session_Repository $_session_Repository)
    {
        $this->_session_Repository = $_session_Repository;
    }










    public static function get_instance(Session_Repository $_session_Repository = new Session_Repository())
    {
      if (self::$_instance == null)
      {
        self::$_instance = new Session_Service($_session_Repository);
      }

      return self::$_instance;
    }








    public function unset_session() : Session_Delete_Response {

        $session_delete_response = new Session_Delete_Response;
        $session_delete_response->session_has_been_unset = false;
        $session_delete_response->note = "It was already unset";

        $session_response_isset = isset($_SESSION["session_response"]);

        if ($session_response_isset)
        {
            unset($_SESSION["session_response"]);
            $session_delete_response->session_has_been_unset = true;
            $session_delete_response->note = "It was active and now it has been destroyed.";

            return $session_delete_response;
        }


        return $session_delete_response;
    }







    private function serialize_session() : void {
        $_SESSION["session_response"] = serialize($this->_session_response);
    }






    public function get_session(): Session_Response
    {

        if (!(isset($_SESSION["session_response"])))
        {
            // Det her er første gang hjemmesiden kender til dig.
            $this->_session_response = new Session_Response;
            $this->_session_response->session = new Session;
            $this->serialize_session();
            return $this->_session_response;
        }

        // henter session hvis den eksistere ellers skabes der en ny.
        $this->_session_response = unserialize($_SESSION["session_response"]);
        return $this->_session_response;

    }








    public function set_session(Session_Response $session_response) : void
    {
        $_SESSION["session_response"] = serialize($session_response);
    }







    // TODO: add_order_item
        // Sub TODO:
    public function add_order_item(int $product_id, int $quantity)
    {
        // Get produkt


        // Check produkt quantity

        // Add to session



    }



    // TODO: set_customer

    // TODO: get_service_points

    // TODO: set_shipment

    // TODO: create_payment

    // TODO: insert to database


    // public function set_customer(Customer $customer) : Get_Session_Response
    // {
    //     $session_response = $this->get_session();

    //     $customer = $session_response->session->customer;

    //     $customer->fullname = 'Victor Reipur';

    //     $_SESSION["session_response"] = serialize($session_response);

    //     return $this->get_session();
    // }




}
