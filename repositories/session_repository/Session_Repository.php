<?php

namespace vezit\repositories\session_repository;


use vezit\entities\Session;
use vezit\entities\Session_Order_Item;
use vezit\classes\mysqli\Mysqli;

require __DIR__ . '/../../global-requirements.php';

class Session_Repository implements ISession_Repository
{

    public function __construct(private $_mysqli = new Mysqli)
    {}

    public function get_all() : array {

        $array_of_sessions = $this->_get_all_from__session_table();


        foreach ($array_of_sessions as $session) {
            $session_order_items = $this->_get_by_order_id_from__session_order_item_table($session->order_id);
            $session->set_order_items($session_order_items);
        }


        return $array_of_sessions;
    }


    public function get_by_order_id(int $order_id) : Session {

        $session = $this->_get_by_order_id_from__session_table($order_id);

        $session_order_items = $this->_get_by_order_id_from__session_order_item_table($order_id);

        $session->set_order_items($session_order_items);

        return $session;

    }



    public function insert(Session $session) : bool {

        if (!($this->_insert_into__session_table($session))) {
            return false;
        }

        if (!($this->_insert_into__session_order_item_table($session))) {
            return false;
        }

        return true;
    }


    public function update(int $order_id, Session $session) : bool {

        if (!($this->_update_session_table($order_id, $session))) {
            return false;
        }

        foreach($session->get_session_order_items() as $session_order_item) {
            if (!($this->_update_session_order_item_table($order_id, $session_order_item->product_id, $session_order_item))) {
                return false;
            }
        }

        return true;
    }

    public function delete(int $order_id) : bool {

        if (!($this->_delete_from__session_table($order_id))) {
            return false;
        }

        if (!($this->_delete_from__session_order_item_table($order_id))) {
            return false;
        }

        return true;
    }


    private function _get_all_from__session_table(): array
    {
        $sql = "SELECT * FROM `session`";
        $stmt = $this->_mysqli->get_db_conn()->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $entities = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        $sessions = [];
        foreach ($entities as $entity) {
            $sessions += [$entity['order_id'] => $this->_session($entity)];
        }



        return $sessions;
    }




    private function _find_by_pk_from_session_table(int $session_pk): Session
    {

        $sql = "SELECT * FROM `session` WHERE session_pk=?";
        $stmt = $this->_mysqli->get_db_conn()->prepare($sql);
        $stmt->bind_param("i", $session_pk);
        $stmt->execute();
        $result = $stmt->get_result();
        $entity = $result->fetch_assoc();
        $stmt->close();

        return $this->_session($entity);
    }


    private function _get_by_order_id_from__session_order_item_table(int $order_id): array
    {
        $sql = "SELECT * FROM `session_order_item` WHERE order_id=?";
        $stmt = $this->_mysqli->get_db_conn()->prepare($sql);
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $entities = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        $session_order_items = [];
        foreach ($entities as $entity) {
            $session_order_items += [$entity['order_id'] => $this->_session_order_item($entity)];
        }

        return $session_order_items;

    }


    private function _get_by_order_id_from__session_table(int $order_id): Session
    {

        $sql = "SELECT * FROM `session` WHERE order_id=?";
        $stmt = $this->_mysqli->get_db_conn()->prepare($sql);
        $stmt->bind_param("i", $order_id);

        if(!($stmt->execute()))
        {
            throw new \Exception("Could not execute statement: " . $stmt->error);
        }

        $result = $stmt->get_result();

        if($result->num_rows == 0)
        {
            throw new \Exception("Could not find session with order_id: " . $order_id);
        }



        $entity = $result->fetch_assoc();
        $stmt->close();

        return $this->_session($entity);
    }


    private function _insert_into__session_table(Session $session): bool
    {


        $sql = "
        INSERT INTO `session`
        ("                                                  .
        "`order_id`"                                        .   // i
        ",`order_status_payment_accepted`"                  .   // i
        ",`order_status_payment_currency`"                  .   // s
        ",`order_status_payment_amount`"                    .   // i
        ",`order_status_payment_quickpay_id`"               .   // i
        ",`order_status_payment_details_satisfied`"         .   // i
        ",`order_status_email_confirmation_sent`"           .   // i
        ",`order_status_email_invoice_sent_to_customer`"    .   // i
        ",`customer_fullname`"                              .   // s
        ",`customer_details_satisfied_for_payment`"         .   // s
        ",`customer_address_street`"                        .   // s
        ",`customer_address_postal_code`"                   .   // i
        ",`customer_address_city`"                          .   // s
        ",`customer_contact_phone`"                         .   // i
        ",`customer_contact_email`"                         .   // s
        ",`customer_company_cvr_number`"                    .   // i
        ",`customer_company_name`"                          .   // s
        ",`shipment_tracking_number`"                       .   // i
        ",`shipment_order_collected`"                       .   // i
        ",`shipment_details_satisfied`"                     .   // i
        ",`shipment_address_street_name`"                   .   // s
        ",`shipment_address_street_number`"                 .   // s
        ",`shipment_address_postal_code`"                   .   // i
        ",`shipment_address_city`"                          .   // s
        ")  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->_mysqli->get_db_conn()->prepare($sql);
        $stmt->bind_param(
            "iisiiiiisssisisisiiissis",

            $session->order_id,
            $session->order_status_payment_accepted,
            $session->order_status_payment_currency,
            $session->order_status_payment_amount,
            $session->order_status_payment_quickpay_id,
            $session->order_status_payment_details_satisfied,
            $session->order_status_email_confirmation_sent,
            $session->order_status_email_invoice_sent_to_customer,
            $session->customer_fullname,
            $session->customer_details_satisfied_for_payment,
            $session->customer_address_street,
            $session->customer_address_postal_code,
            $session->customer_address_city,
            $session->customer_contact_phone,
            $session->customer_contact_email,
            $session->customer_company_cvr_number,
            $session->customer_company_name,
            $session->shipment_tracking_number,
            $session->shipment_order_collected,
            $session->shipment_details_satisfied,
            $session->shipment_address_street_name,
            $session->shipment_address_street_number,
            $session->shipment_address_postal_code,
            $session->shipment_address_city
        );


        if(!($stmt->execute()))
        {
            throw new \Exception("Could not execute statement: " . $stmt->error);
            $stmt->close();
            return false;
        }

        $stmt->close();
        return true;
    }


    public function _insert_into__session_order_item_table(Session $session): bool
    {
        $sql = "INSERT INTO `session_order_item`
        (
        ,`order_id`
        ,`product_id`
        ,`product_name`
        ,`price`
        ,`quantity`
        ) VALUES (?, ?, ?, ?, ?)";

        $session_order_items = $session->get_session_order_items();

        foreach($session_order_items as $session_order_item)
        {
            $stmt = $this->_mysqli->get_db_conn()->prepare($sql);
            $stmt->bind_param("iisii",
                $session_order_item->order_id,
                $session_order_item->product_id,
                $session_order_item->product_name,
                $session_order_item->price,
                $session_order_item->quantity,
            );
            if(!($stmt->execute()))
            {
                throw new \Exception("Could not execute statement: " . $stmt->error);
                $stmt->close();
                return false;
            }

            $stmt->close();

        }
        return true;
    }


    private function _update_session_table(int $order_id, Session $session): bool
    {

        $sql = "
        UPDATE `session`
        SET
        `order_status_payment_accepted` =                   ?
        ,`order_status_payment_currency` =                  ?
        ,`order_status_payment_amount` =                    ?
        ,`order_status_payment_quickpay_id` =               ?
        ,`order_status_payment_details_satisfied` =         ?
        ,`order_status_email_confirmation_sent` =           ?
        ,`order_status_email_invoice_sent_to_customer` =    ?
        ,`customer_fullname` =                              ?
        ,`customer_details_satisfied_for_payment` =         ?
        ,`customer_address_street` =                        ?
        ,`customer_address_postal_code` =                   ?
        ,`customer_address_city` =                          ?
        ,`customer_contact_phone` =                         ?
        ,`customer_contact_email` =                         ?
        ,`customer_company_cvr_number` =                    ?
        ,`customer_company_name` =                          ?
        ,`shipment_tracking_number` =                       ?
        ,`shipment_order_collected` =                       ?
        ,`shipment_details_satisfied` =                     ?
        ,`shipment_address_street_name` =                   ?
        ,`shipment_address_street_number` =                 ?
        ,`shipment_address_postal_code` =                   ?
        ,`shipment_address_city` =                          ?
        WHERE `order_id` = ?";
        $stmt = $this->_mysqli->get_db_conn()->prepare($sql);
        $stmt->bind_param(
            "isiiiiisssisisisisiiissi",
            $session->order_status_payment_accepted,
            $session->order_status_payment_currency,
            $session->order_status_payment_amount,
            $session->order_status_payment_quickpay_id,
            $session->order_status_payment_details_satisfied,
            $session->order_status_email_confirmation_sent,
            $session->order_status_email_invoice_sent_to_customer,
            $session->customer_fullname,
            $session->customer_details_satisfied_for_payment,
            $session->customer_address_street,
            $session->customer_address_postal_code,
            $session->customer_address_city,
            $session->customer_contact_phone,
            $session->customer_contact_email,
            $session->customer_company_cvr_number,
            $session->customer_company_name,
            $session->shipment_tracking_number,
            $session->shipment_order_collected,
            $session->shipment_details_satisfied,
            $session->shipment_address_street_name,
            $session->shipment_address_street_number,
            $session->shipment_address_postal_code,
            $session->shipment_address_city,
            $order_id
        );

        if(!($stmt->execute()))
        {
            throw new \Exception("Could not execute statement: " . $stmt->error);
            $stmt->close();
            return false;
        }

        $stmt->close();
        return true;


    }

    private function _update_session_order_item_table(int $order_id, int $product_id, Session_Order_Item $session_order_item) : bool
    {
        $sql = "
        UPDATE `session_order_item`
        SET
        `product_name`     =                          ?
        ,`price`            =                          ?
        ,`quantity`         =                          ?
        WHERE `order_id` = ? AND `product_id` = ?";

        $stmt = $this->_mysqli->get_db_conn()->prepare($sql);
        $stmt->bind_param(
            "siiii",
            $session_order_item->product_name,
            $session_order_item->price,
            $session_order_item->quantity,
            $order_id,
            $product_id
        );

        if(!($stmt->execute()))
        {
            throw new \Exception("Could not execute statement: " . $stmt->error);
            $stmt->close();
            return false;
        }

        $stmt->close();
        return true;
    }

    private function _delete_session_table(int $order_id): bool
    {
        $sql = "DELETE FROM `session` WHERE `order_id` = ?";
        $stmt = $this->_mysqli->get_db_conn()->prepare($sql);
        $stmt->bind_param("i", $order_id);
        if(!($stmt->execute()))
        {
            throw new \Exception("Could not execute statement: " . $stmt->error);
            $stmt->close();
            return false;
        }

        $stmt->close();
        return true;
    }


    private function _delete_session_order_item_table(int $order_id): bool
    {
        $sql = "DELETE FROM `session_order_item` WHERE `order_id` = ?";
        $stmt = $this->_mysqli->get_db_conn()->prepare($sql);
        $stmt->bind_param("i", $order_id);
        if(!($stmt->execute()))
        {
            throw new \Exception("Could not execute statement: " . $stmt->error);
            $stmt->close();
            return false;
        }

        $stmt->close();
        return true;
    }


    private function _session_order_item(array $entity) : Session_Order_Item
    {

        return new Session_Order_Item(
            $entity['session_order_item_pk'],
            $entity['order_id'],
            $entity['product_id'],
            $entity['product_name'],
            $entity['price'],
            $entity['quantity']
        );
    }

    private function _session(array $entity): Session
    {





        return new Session(
            $entity['session_pk'],
            $entity['order_id'],
            $entity['order_status_payment_accepted'],
            $entity['order_status_payment_currency'],
            $entity['order_status_payment_amount'],
            $entity['order_status_payment_quickpay_id'],
            $entity['order_status_payment_details_satisfied'],
            $entity['order_status_email_confirmation_sent'],
            $entity['order_status_email_invoice_sent_to_customer'],
            $entity['customer_fullname'],
            $entity['customer_details_satisfied_for_payment'],
            $entity['customer_address_street'],
            $entity['customer_address_postal_code'],
            $entity['customer_address_city'],
            $entity['customer_contact_phone'],
            $entity['customer_contact_email'],
            $entity['customer_company_cvr_number'],
            $entity['customer_company_name'],
            $entity['shipment_tracking_number'],
            $entity['shipment_order_collected'],
            $entity['shipment_details_satisfied'],
            $entity['shipment_address_street_name'],
            $entity['shipment_address_street_number'],
            $entity['shipment_address_postal_code'],
            $entity['shipment_address_city']

        );
    }


}
