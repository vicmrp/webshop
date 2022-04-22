<?php

namespace vezit\entities\session;

require __DIR__ . '/../../global-requirements.php';

use vezit\entities\class\customer\Customer;
use vezit\entities\class\order\Order;
use vezit\entities\class\shipment\Shipment;
use vezit\entities\class\order\item\Item;


class Session_Entity
{

    public function __construct(
        public ?int      $session_pk                                     = null,
        public int      $session_id                                     = 0,
        public string   $customer_fullname                              = '',
        public bool     $customer_details_satisfied_for_payment         = false,
        public string   $customer_address_street                        = '',
        public int      $customer_address_postal_code                   = 0,
        public string   $customer_address_city                          = '',
        public string   $customer_address_country                       = '',
        public string   $customer_address_phone                         = '',
        public string   $customer_address_email                         = '',
        public string   $customer_company_cvr_number                    = '',
        public string   $customer_company_name                          = '',
        public int      $order_id                                       = 0,
        public Item     $order_item                                     = new Item,
        public bool     $order_status_payment_accepted                  = false,
        public string   $order_status_payment_currency                  = '',
        public int      $order_status_payment_amount                    = 0,
        public int      $order_status_payment_quickpay_id               = 0,
        public bool     $order_status_payment_details_satisfied         = false,
        public bool     $order_status_email_confirmation_sent           = false,
        public bool     $order_status_email_invoice_sent_to_customer    = false,
        public int      $shipment_tracking_number                       = 0,
        public bool     $shipment_order_collected                       = false,
        public bool     $shipment_details_satisfied                     = false,
        public string   $shipment_address_street_name                   = '',
        public int      $shipment_address_street_number                 = 0,
        public int      $shipment_address_postal_code                   = 0,
        public string   $shipment_address_city                          = '',
    )
    { }
}
