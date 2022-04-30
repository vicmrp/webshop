<?php

namespace vezit\entities;

require __DIR__ . '/../global-requirements.php';


class Session
{

    public function __construct(
        // Repræsenterer en session i databasen
        public   ?int       $session_pk                                     = null,
        public   ?int       $order_id                                       = null,
        public   bool       $order_status_payment_accepted                  = false,
        public   string     $order_status_payment_currency                  = '',
        public   int        $order_status_payment_amount                    = 0,
        public   int        $order_status_payment_quickpay_id               = 0,
        public   bool       $order_status_payment_details_satisfied         = false,
        public   bool       $order_status_email_confirmation_sent           = false,
        public   bool       $order_status_email_invoice_sent_to_customer    = false,
        public   string     $customer_fullname                              = '',
        public   bool       $customer_details_satisfied_for_payment         = false,
        public   string     $customer_address_street                        = '',
        public   int        $customer_address_postal_code                   = 0,
        public   string     $customer_address_city                          = '',
        public   int        $customer_contact_phone                         = 0,
        public   string     $customer_contact_email                         = '',
        public   ?int       $customer_company_cvr_number                    = null,
        public   ?string    $customer_company_name                          = null,
        public   int        $shipment_tracking_number                       = 0,
        public   bool       $shipment_order_collected                       = false,
        public   bool       $shipment_details_satisfied                     = false,
        public   string     $shipment_address_street_name                   = '',
        public   string     $shipment_address_street_number                 = '',
        public   int        $shipment_address_postal_code                   = 0,
        public   string     $shipment_address_city                          = '',

        // sub-entities - en undertabel
        private  array $session_order_items = [],
    )
    {

        array_walk($session_order_items, function ($session_order_item) {

            if (!($session_order_item instanceof Session_Order_Item)) {
                throw new \Exception('Order_Item must be an instance of Session_Order_Item');
            }

            if ($session_order_item->order_id !== $this->order_id) {
                throw new \Exception('session_order_item->order_id must be the same as session->order_id');
            }
        });
    }


    public function get_session_order_items(): array
    {
        return $this->session_order_items;
    }


    public function set_order_items(array $session_order_items)
    {
        array_walk($session_order_items, function ($session_order_item) {
            if (!($session_order_item instanceof Session_Order_Item)) {
                throw new \Exception('Order_Items must be an instance of Order_Item');
            }
        });
        $this->session_order_items = $session_order_items;
    }
}