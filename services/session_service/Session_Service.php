<?php namespace vezit\services\session_service;
use vezit\models\session\Session;
use vezit\dto\Session_Response;
use vezit\dto\Session_Delete_Response;
use vezit\dto\Session_Update_Customer_Request;
use vezit\repositories\session_repository\Session_Repository;
use vezit\entities\session\Session_Entity;
use vezit\models\session\order\item\Item;

require __DIR__ . '/../../global-requirements.php';

class Session_Service
{
    private static $_instance = null;
    private Session_Repository $_session_Repository;
    private Session_Response $_session_response;







    private function __construct(Session_Repository $_session_Repository)
    {
        $this->_session_Repository = $_session_Repository;
        $this->get_session();
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


    public function update_customer($customer) : Session_Response {
        $this->_session_response->session->customer->fullname                           = $customer->fullname;
        $this->_session_response->session->customer->address->street                    = $customer->address->street;
        $this->_session_response->session->customer->address->postal_code               = $customer->address->postal_code;
        $this->_session_response->session->customer->address->city                      = $customer->address->city;
        $this->_session_response->session->customer->contact->phone                     = $customer->contact->phone;
        $this->_session_response->session->customer->contact->email                     = $customer->contact->email;
        $this->_session_response->session->customer->company->cvr_number                = $customer->company->cvr_number;
        $this->_session_response->session->customer->company->company_name              = $customer->company->company_name;


        $this->_session_response->session->customer->details_satisfied_for_payment = $this->_customer_details_is_satisfied();


        $this->serialize_session();
        return $this->get_session();
    }



    public function update_order($order) : Session_Response {
        // $this->_session_response->session->order->id = $order->id;

        $items = [];
        // TODO skal kun tilføje hvis de er pa lager ellers returner maks antal.
        foreach($order->items as $pk => $item) {
            $item = new Item(
                $session_order_item_pk = 1,
                $product_pk_fk = 1,
                $name = "Steen karriære",
                $price = 12345,
                $quantity = 1
            );
            $items += [$item];
        }




        $this->_session_response->session->order->set_order_items($items);

        // TODO fix alle dem her sa de er automatiske
        // $this->_session_response->session->order->status->payment->accepted
        // $this->_session_response->session->order->status->payment->amount
        // $this->_session_response->session->order->status->payment->currency
        // $this->_session_response->session->order->status->payment->details_satisfied_for_payment
        // $this->_session_response->session->order->status->email->confirmation_sent
        // $this->_session_response->session->order->status->email->invoice_sent_to_customer


        $this->serialize_session();
        return $this->get_session();
    }


    private function _customer_details_is_satisfied() : bool {

        if (null === $this->_session_response->session->customer->fullname            ) return false;
        if (null === $this->_session_response->session->customer->address->street     ) return false;
        if (null === $this->_session_response->session->customer->address->postal_code) return false;
        if (null === $this->_session_response->session->customer->address->city       ) return false;
        if (null === $this->_session_response->session->customer->contact->phone      ) return false;
        if (null === $this->_session_response->session->customer->contact->email      ) return false;

        return true;
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
