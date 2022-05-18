<?php

namespace vezit\repositories\session_repository;


use vezit\entities\Session;
use vezit\entities\Sessions;
use vezit\entities\Session_Order_Item;
use vezit\classes\mysqli\Mysqli;
use vezit\entities\Session_Order_Items;
use vezit\repositories\super_repository\Super_Repository;

require __DIR__ . '/../../global-requirements.php';

class Session_Repository
{

    public function __construct(private Super_Repository $_super_repository = new Super_Repository())
    {}

    public function get_all() : Sessions
    {

        $sessions = $this->_get_all_from__session_table();


        foreach ($sessions->get() as $session) {

            $session_order_items = $this->_get_all_from__session_order_item_table($fk = $session->session_pk);
            $session->set_session_order_items($session_order_items);
        }


        return $sessions;
    }


    public function get_by_pk(int $pk) : Session {

        $session =  $this->get_one_entity_from__session_table($pk);

        $session_order_items = $this->_get_all_from__session_order_item_table($fk = $session->session_pk);

        $session->set_session_order_items($session_order_items);

        return $session;

    }


    public function insert(Session $session) : bool
    {

        if (!($this->_insert_into__session_table($session))) {
            return false;
        }

        $sessions = $this->get_all()->get();
        usort($sessions, function($a, $b) { return $a->session_pk - $b->session_pk; });
        $fresh_session = $sessions[array_key_last($sessions)];

        $session_pk_fk = $fresh_session->session_pk;
        $session_order_items = $session->get_session_order_items();

        foreach($session_order_items as $session_order_item) {
            $session_order_item->session_pk_fk = $session_pk_fk;
            if (!($this->_insert_into__session_order_item_table($session_order_item))) {
                return false;
            }
        }
        return true;
    }

    public function update(int $pk, Session $session) : bool
    {

        if (!($this->_update__session_table($pk, $session))) {
            return false;
        }

        $session_order_items = $session->get_session_order_items();
        foreach($session_order_items as $session_order_item) {
            $fk = $session_order_item->session_pk_fk;
            if (!($this->_update__session_order_item_table($fk, $session_order_item))) {
                return false;
            }
        }
        return true;
    }

    public function delete(int $order_id) : bool
    {

        if (!($this->_delete_from__session_table($order_id))) {
            return false;
        }

        if (!($this->_delete_from__session_order_item_table($order_id))) {
            return false;
        }

        return true;
    }

    private function _get_all_from__session_table(): Sessions
    {
        $sessions = new Sessions();
        $array = [];

        $entities = $this->_super_repository->get_all("session");

        foreach ($entities as $entity) {
            $array += [$entity['session_pk'] => $this->_construct_session_entity($entity)];
        }

        $sessions->set($array);

        return $sessions;
    }

    private function get_one_entity_from__session_table(int $pk) : Session
    {

        // get seesion entity
        $entities = $this->_super_repository
            ->get_all_by_where_clause($table='session', $where_clause='session_pk', $identifier=$pk);

        if (null != $entities[0])
            $entity = $entities[0];

        return $this->_construct_session_entity($entity);
    }

    private function _get_all_from__session_order_item_table(int $fk): Session_Order_Items
    {
        $session_order_items = new Session_Order_Items;
        $array = [];


        $entities = $this->_super_repository->get_all_by_where_clause($table="session_order_item", $where_clause="session_pk_fk", $identifier=$fk);


        foreach ($entities as $entity) {
            $array += [$entity['session_order_item_pk'] => $this->_construct_session_order_item_dto($entity)];
        }

        $session_order_items->set($array);
        return  $session_order_items;

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

        return $this->_set_session($entity);
    }


    private function _insert_into__session_table(Session $session): bool
    {
        $fields_to_ignore = ['session_pk', 'datetime_created', 'datetime_last_modified'];
        return $this->_super_repository->insert_entity($session, 'session', $fields_to_ignore);
    }


    public function _insert_into__session_order_item_table(Session_Order_Item $session_order_item): bool
    {
        $fields_to_ignore = ['session_order_item_pk', 'datetime_created', 'datetime_last_modified'];
        return $this->_super_repository->insert_entity($session_order_item, $table = 'session_order_item', $fields_to_ignore);
    }


    private function _update__session_table(int $pk, Session $session): bool
    {
        $fields_to_ignore = ['session_pk', 'order_id', 'datetime_created', 'datetime_last_modified'];
        return $this->_super_repository
        ->update_entity(
            $object_be_updated = $session,
            $table = 'session',
            $where_clause = 'session_pk',
            $identifier=$pk,
            $fields_to_ignore);
    }

    private function _update__session_order_item_table(int $fk, Session_Order_Item $session_order_item) : bool
    {
        return $this->_super_repository
        ->update_entity(
            $object_be_updated = $session_order_item,
            $table = 'session_order_item',
            $where_clause = 'session_pk_fk',
            $identifier=$fk);
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





    private function _construct_session_order_item_dto(array $entity) : Session_Order_Item {
        return new Session_Order_Item(
            $entity['session_order_item_pk'],
            $entity['session_pk_fk'],
            $entity['product_pk_fk'],
            new \DateTime($entity['datetime_created']),
            new \DateTime($entity['datetime_last_modified']),
            $entity['name'],
            $entity['price'],
            $entity['quantity']
        );
    }

    private function _construct_session_entity(array $entity): Session
    {
        return new Session(
            $entity['session_pk'],
            $entity['order_id'],
            new \DateTime($entity['datetime_created']),
            new \DateTime($entity['datetime_last_modified']),
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
