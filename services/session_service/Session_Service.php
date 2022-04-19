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

    public function get_session(): Session_Response
    {

        // henter session hvis den eksistere ellers skabes der en ny.
        if (isset($_SESSION["session_response"]) === true)
        {
            $session_response = unserialize($_SESSION["session_response"]);
            return $session_response;
        }


        $customer_address = new Customer_Address($street = '', $postal_code = '0000', $city = '');
        $customer_contact = new Customer_Contact($phone_number = '', $email = '');
        $customer_company = new Customer_Company($cvr_number = '', $company_name = '');
        $customer = new Customer($fullname = '', $customer_details_satisfied = true, $customer_address, $customer_contact, $customer_company);

        $order_payment = new Order_Payment($accepted = false, $currency = 'DKK', $total_amount = 100, $payment_quickpay_id = 1, $payment_details_satisfied = false);
        $email = new Email($confirmation_sent = false, $invoice_sent_to_customer = false);
        $order_status = new Order_Status($order_payment, $email);
        // $order_item = new Order_Item($product_name = '', $product_id = 0, $price = 100, $quantity = 1);
        $order = new Order($order_id = 1, $order_items = [], $order_status);

        $shipment_address = new Shipment_Address($street_name = '', $street_number = '', $postal_code = '0000', $city = '');
        $shipment = new Shipment($tracking_number = '', $order_collected = false, $shipment_details_satisfied = false, $shipment_address);
        $session = new Session($session_id = 1, $customer, $order, $shipment);
        $session_response = new Session_Response($session);

        $_SESSION["session_response"] = serialize($session_response);

        return $session_response;
    }

    private function set_storing_session_response(): void
    {
    }
}
