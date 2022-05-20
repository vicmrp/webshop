<?php namespace vezit\services\session_service;
use vezit\models\session\Session;
use vezit\dto\Session_Response;
use vezit\dto\Session_Delete_Response;
use vezit\dto\Session_Update_Customer_Request;
use vezit\repositories\session_repository\Session_Repository;
use vezit\entities\session\Session_Entity;
use vezit\models\session\order\item\Item;
use vezit\repositories\product_repository\Product_Repository;

require __DIR__ . '/../../global-requirements.php';

class Session_Service
{
    private static $_instance = null;
    private Session_Repository $_session_repository;
    private Product_Repository $_product_repository;
    private Session_Response $_session_response;







    private function __construct(Session_Repository $session_Repository, Product_Repository $product_repository)
    {
        $this->_session_Repository = $session_Repository;
        $this->_product_repository = $product_repository;
        $this->get_session();
    }










    public static function get_instance(Session_Repository $session_Repository = new Session_Repository(), Product_Repository $product_repository = new Product_Repository())
    {
      if (self::$_instance == null)
      {
        self::$_instance = new Session_Service($session_Repository, $product_repository);
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






    public function get_session(): Session_Response {


        if (!(isset($_SESSION["session_response"])))
        {
            // Det her er første gang hjemmesiden kender til dig.
            $this->_session_response = new Session_Response;
            $this->_session_response->session = new Session;

            // Default values
            $this->_session_response->session->order->status->payment->accepted = false;
            $this->_session_response->session->order->status->payment->currency = "DKK";
            $this->_session_response->session->order->status->payment->details_satisfied_for_payment = false;
            $this->_session_response->session->order->status->email->confirmation_sent = false;
            $this->_session_response->session->order->status->email->invoice_sent_to_customer = false;


            $this->serialize_session();
            return $this->get_session();
        }

        // henter session hvis den eksistere ellers skabes der en ny.
        $this->_session_response = unserialize($_SESSION["session_response"]);
        return $this->_session_response;

    }






    public function set_session(Session_Response $session_response) : void {
        $_SESSION["session_response"] = serialize($session_response);
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
        $amount = 0;
        // TODO skal kun tilføje hvis de er pa lager ellers returner maks antal.
        foreach($order->items as $pk => $item) {
            $product = $this->_product_repository->get_by_pk($pk);
            $item = new Item(
                $product_pk_fk = $product->product_pk,
                $name = $product->name,
                $price = $product->price,
                $quantity = $item->quantity
            );

            $amount += $product->price * $item->quantity;
            $items  += [$pk => $item];
        }


        //TODO make sure you cannot buy more books than is in stock. This is an asyncronous problem
        $this->_session_response->session->order->set_order_items($items);
        $this->_session_response->session->order->status->payment->amount = $amount;

        $this->_session_response->session->order->status->payment->details_satisfied_for_payment = $this->_order_details_is_satisfied();
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

    private function _order_details_is_satisfied() : bool {
        if (null === $this->_session_response->session->order->status->payment->amount) return false;
        if (0 >= $this->_session_response->session->order->status->payment->amount) return false;

        return true;
    }

    private function _shipment_details_is_satisfied() : bool {
        if (null === $this->_session_response->session->shipment->address->street_name)     return false;
        if (null === $this->_session_response->session->shipment->address->street_number)   return false;
        if (null === $this->_session_response->session->shipment->address->postal_code)     return false;
        if (null === $this->_session_response->session->shipment->address->city)            return false;
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
