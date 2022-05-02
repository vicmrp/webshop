<?php

namespace vezit\services\session_service;


use vezit\dto\session\Session;
use vezit\dto\session\response\Session_Response;
use vezit\dto\class\session\customer\Customer;
use vezit\dto\class\session\customer\address\Address as Customer_Address;
use vezit\dto\class\session\customer\company\Company as Customer_Company;
use vezit\dto\class\session\customer\contact\Contact as Customer_Contact;
use vezit\dto\class\session\order\Order;
use vezit\dto\class\session\order\item\Item;
use vezit\dto\class\session\order\status\Status;
use vezit\dto\class\session\order\status\email\Email;
use vezit\dto\class\session\order\status\payment\Payment;
use vezit\dto\class\session\shipment\Shipment;
use vezit\dto\class\session\shipment\address\Address as Shipment_Address;
use vezit\dto\unset_session\response\Unset_Session_Response;
use vezit\repositories\session_repository\Session_Repository;
use vezit\services\product_service\Product_Service;
use vezit\entities\session\Session_Entity;

require __DIR__ . '/../../global-requirements.php';

class Session_Service
{

    public function __construct(private Product_Service $_product_service = new Product_Service)
    {
    }

    public function unset_session() : Unset_Session_Response {

        $unset_session_response = new Unset_Session_Response;

        if (isset($_SESSION["session_response"]) === true)
        {
            unset($_SESSION["session_response"]);
            $unset_session_response->session_has_been_unset = true;
        }

        $unset_session_response->session_has_been_unset = false;
        return $unset_session_response;
    }


    public function get_session(): Session_Response
    {


        // henter session hvis den eksistere ellers skabes der en ny.
        if (isset($_SESSION["session_response"]) === true)
        {
            $session_response = unserialize($_SESSION["session_response"]);
            return $session_response;
        }

        $session_response = new Session_Response;

        $_SESSION["session_response"] = serialize($session_response);

        return $session_response;
    }


    public function set_customer(Customer $cu) : Session_Response
    {
        $session_response = $this->get_session();

        $customer = $session_response->session->customer;

        $customer->fullname = 'Victor Reipur';

        $_SESSION["session_response"] = serialize($session_response);

        return $this->get_session();
    }


    public function insert_session_to_database() : bool
    {

        $session_response = $this->get_session();

        $session_repository = new Session_Repository;
        $session_entity = new Session_Entity(
            $session_response->session->session_pk = null,
            $session_response->session->session_id,
            $session_response->session->customer->fullname,
            $session_response->session->customer->details_satisfied_for_payment,
            $session_response->session->customer->address->street,
            $session_response->session->customer->address->postal_code,
            $session_response->session->customer->address->city,
            $session_response->session->customer->address->country,
            $session_response->session->customer->address->phone,
            $session_response->session->customer->address->email,
            $session_response->session->customer->company->cvr_number,
            $session_response->session->customer->company->name,
            $session_response->session->order->order_id,
            $session_response->session->order->item,
            $session_response->session->order->status->payment->accepted,
            $session_response->session->order->status->payment->currency,
            $session_response->session->order->status->payment->amount,
            $session_response->session->order->status->payment->quickpay_id,
            $session_response->session->order->status->payment->details_satisfied,
            $session_response->session->order->status->email->confirmation_sent,
            $session_response->session->order->status->email->invoice_sent_to_customer,
            $session_response->session->shipment->tracking_number,
            $session_response->session->shipment->order_collected,
            $session_response->session->shipment->details_satisfied,
            $session_response->session->shipment->address->street_name,
            $session_response->session->shipment->address->street_number,
            $session_response->session->shipment->address->postal_code,
            $session_response->session->shipment->address->city
        );


        return $session_repository->insert($session_entity);
    }

}
