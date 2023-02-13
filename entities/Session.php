<?php namespace vezit\entities;

use DateTime;

require __DIR__ . '/../global-requirements.php';


class Session
{

    public function __construct(
        // Repræsenterer en session i databasen
        public   ?int           $session_pk                                     = null,
        public   ?string        $order_id                                       = null,
        public   ?\DateTime     $datetime_created                               = null,
        public   ?\DateTime     $datetime_last_modified                         = null,
        public   ?bool          $order_status_payment_accepted                  = null,
        public   ?string        $order_status_payment_currency                  = null,
        public   ?int           $order_status_payment_amount                    = null,
        public   ?int           $order_status_payment_quickpay_id               = null,
        public   ?bool          $order_status_email_invoice_sent_to_customer    = null,
        public   ?string        $customer_fullname                              = null,
        public   ?bool          $customer_tos_and_tac_has_been_accepted         = null,
        public   ?string        $customer_contact_email                         = null,



        // sub-entities - en undertabel
        private  Session_Order_Items $session_order_items = new Session_Order_Items
    )
    {}


    public function get_session_order_items() : array {
        return $this->session_order_items->get();
    }

    public function set_session_order_items(Session_Order_Items $session_order_items) : void {
        $this->session_order_items = $session_order_items;
    }

    public function modify_session_order_item(Session_Order_Item $session_order_item) : bool {
        // if exist
        $session_order_items = $this->session_order_items->get();
        $pk = $session_order_item->session_order_item_pk;

        if (!(g_find_object_by_id($pk, $session_order_items))) {

            $session_order_items[$pk] = [$pk => $session_order_item];
            return true;
        }

        return false;
    }


    public function __set($name, $value)
    {
        throw new \Exception('Cant set!' . $name . ', ' . $value);
    }

}