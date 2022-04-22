<?php


require __DIR__ . '/../../../global-requirements.php';

use vezit\dto\session\Session;
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



$customer_address = new Customer_Address('Street', 2800, 'City', 'Country');
$customer_contact = new Customer_Contact(26129604, 'Email');
$customer_company = new Customer_Company('CVR', 'Company');
$customer = new Customer($fullname = 'John Doe', $details_satisfied_for_payment = true, $customer_address, $customer_contact, $customer_company);

$order_payment = new Payment($accepted = false, $currency = 'DKK', $amount = 100, $quickpay_id = 1, $details_satisfied_for_payment = false);
$order_email = new Email($confirmation_sent = false, $invoice_sent_to_customer = false);
$order_item = new Item($id = 1, $name = 'Product_1', $price = 100, $quantity = 1);
$order_status = new Status($order_payment, $order_email);
$order = new Order($id = 1, $items = [$order_item], $order_status);

$shipment_address = new Shipment_Address($street_name = "Street", $street_number = "17", $postal_code = 2800, $city = "Lyngby");
$shipment = new Shipment($tracking_number = "", $collected = false, $details_satisfied_for_payment = false, $shipment_address);
$session = new Session($session_id = 9150356, $customer, $order, $shipment);

// echo serialize($session);
// dd($session);
echo json_encode($session, JSON_PRETTY_PRINT);
