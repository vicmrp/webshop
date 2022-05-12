<?php namespace vezit\entities;

require __DIR__ . '/../global-requirements.php';


class Session
{

    public function __construct(
        // Repræsenterer en session i databasen
        public   ?int           $session_pk                                     = null,
        public   ?int           $order_id                                       = null,
        public   ?bool          $order_status_payment_accepted                  = null,
        public   ?string        $order_status_payment_currency                  = null,
        public   ?int           $order_status_payment_amount                    = null,
        public   ?int           $order_status_payment_quickpay_id               = null,
        public   ?bool          $order_status_payment_details_satisfied         = null,
        public   ?bool          $order_status_email_confirmation_sent           = null,
        public   ?bool          $order_status_email_invoice_sent_to_customer    = null,
        public   ?string        $customer_fullname                              = null,
        public   ?bool          $customer_details_satisfied_for_payment         = null,
        public   ?string        $customer_address_street                        = null,
        public   ?int           $customer_address_postal_code                   = null,
        public   ?string        $customer_address_city                          = null,
        public   ?int           $customer_contact_phone                         = null,
        public   ?string        $customer_contact_email                         = null,
        public   ?int           $customer_company_cvr_number                    = null,
        public   ?string        $customer_company_name                          = null,
        public   ?int           $shipment_tracking_number                       = null,
        public   ?bool          $shipment_order_collected                       = null,
        public   ?bool          $shipment_details_satisfied                     = null,
        public   ?string        $shipment_address_street_name                   = null,
        public   ?string        $shipment_address_street_number                 = null,
        public   ?int           $shipment_address_postal_code                   = null,
        public   ?string        $shipment_address_city                          = null,

        // sub-entities - en undertabel
        public  ?Session_Order_Items $session_order_items = null
    )
    {}

}