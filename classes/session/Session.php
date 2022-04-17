<?php

namespace vezit\classes\session;

require __DIR__ . '/../../global-requirements.php';

use vezit\classes\session\customer\Customer as Customer;
use vezit\classes\session\customer\address\Address as Customer_Address;
use vezit\classes\session\customer\company\Company as Customer_Company;
use vezit\classes\session\customer\contact\Contact as Customer_Contact;
use vezit\classes\session\order\Order;
use vezit\classes\session\order\order_item\Order_Item;
use vezit\classes\session\order\order_status\Order_Status;
use vezit\classes\session\order\order_status\payment\Payment as Order_Payment;
use vezit\classes\session\shipment\Shipment;
use vezit\classes\session\shipment\address\Address as Shipment_Address;


class Session
{
    public function __construct(
        public int $session_id,
        public Customer $customer,
        public Order $order,
        public Shipment $shipment
    )
    {}
}
