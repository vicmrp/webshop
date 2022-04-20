<?php

namespace vezit\services\session_service;


use vezit\dto\session\response\Session_Response;
use vezit\services\product_service\Product_Service;
use vezit\dto\class\session\Session;
use vezit\dto\class\session\customer\Customer as Customer;
use vezit\dto\class\session\customer\address\Address as Customer_Address;
use vezit\dto\class\session\customer\company\Company as Customer_Company;
use vezit\dto\class\session\customer\contact\Contact as Customer_Contact;
use vezit\dto\class\session\order\Order;
use vezit\dto\class\session\order\order_item\Order_Item;
use vezit\dto\class\session\order\order_status\Order_Status;
use vezit\dto\class\session\order\order_status\email\Email;
use vezit\dto\class\session\order\order_status\payment\Payment as Order_Payment;
use vezit\dto\class\session\shipment\Shipment;
use vezit\dto\class\session\shipment\address\Address as Shipment_Address;

require __DIR__ . '/../../global-requirements.php';

class Session_Service
{

    public function __construct(private Product_Service $product_service)
    {
    }

    public function unset_session() : object {
        if (isset($_SESSION["session_response"]) === true)
        {
            unset($_SESSION["session_response"]);
            return (object)['session_has_been_unset' => true];
        }
        return (object)['session_has_been_unset' => false];
    }


    public function get_session(): Session_Response
    {


        // henter session hvis den eksistere ellers skabes der en ny.
        if (isset($_SESSION["session_response"]) === true)
        {
            $session_response = unserialize($_SESSION["session_response"]);
            return $session_response;
        }


        // $customer_address = new Customer_Address;
        // $customer_contact = new Customer_Contact;
        // $customer_company = new Customer_Company;
        // $customer = new Customer;

        // $order_payment = new Order_Payment;
        // $email = new Email;
        // $order_status = new Order_Status();
        // // $order_item = new Order_Item($product_name = '', $product_id = 0, $price = 100, $quantity = 1);
        // $order = new Order();

        // $shipment_address = new Shipment_Address($street_name = '', $street_number = '', $postal_code = '', $city = '');
        // $shipment = new Shipment($tracking_number = '', $order_collected = false, $shipment_details_satisfied = false, $shipment_address);
        // $session = new Session($session_id = 1, $customer, $order, $shipment);
        $session_response = new Session_Response;

        $_SESSION["session_response"] = serialize($session_response);

        return $session_response;
    }


    public function set_customer() : Session_Response
    {
        $session_response = $this->get_session();

        $customer = $session_response->session->customer;

        $customer->fullname = 'Victor Reipur';

        $_SESSION["session_response"] = serialize($session_response);

        return $this->get_session();

    }

}
