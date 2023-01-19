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

    private static $_times_instantiated = 0;
    private static $_instance = null;




    public static function get_instance(Super_Repository $super_repository = null)
    {
        return (null === self::$_instance) ? new Session_Repository(

            (null === $super_repository) ? Super_Repository::get_instance() : $super_repository

        ) : self::$_instance;
    }


    private function __construct(private Super_Repository $_super_repository)
    {
        self::$_times_instantiated++;
    }



























































    // the public method that gets the Sessions including the Session_Order_Items - the related entities
    public function get_all($key = 'session_pk'): Sessions
    {

        // Get all the Sessions from the Session table
        $sessions = $this->_get_all_from__session_table($key);


        foreach ($sessions->get() as $session) {

            $session_order_items = $this->_get_all_from__session_order_item_table($where_clause = "session_pk_fk", $fk = $session->session_pk);
            $session->set_session_order_items($session_order_items);
        }


        return $sessions;
    }

    private function _get_all_from__session_table($key): Sessions
    {
        $sessions = new Sessions();
        $array = [];

        $entities = $this->_super_repository->get_all("session");

        foreach ($entities as $entity) {
            $array += [$entity[$key] => $this->_construct_session_entity($entity)];
        }

        $sessions->set($array);

        return $sessions;
    }


















































    public function get_by_pk(int $pk): Session
    {

        $session =  $this->_get_one_entity_from__session_table($where_clause = 'session_pk', $identifier = $pk);

        $session_order_items = $this->_get_all_from__session_order_item_table($where_clause = "session_pk_fk", $identifier = $session->session_pk);

        $session->set_session_order_items($session_order_items);

        return $session;
    }





    public function get_by_order_id(string $order_id): Session
    {

        $session =  $this->_get_one_entity_from__session_table($where_clause = 'order_id', $identifier = $order_id);

        $session_order_items = $this->_get_all_from__session_order_item_table($where_clause = "session_pk_fk", $identifier = $session->session_pk);

        $session->set_session_order_items($session_order_items);

        return $session;
    }






    private function _get_one_entity_from__session_table(string $where_clause, $identifier): Session
    {
        $TABLE = 'session';

        // get seesion entity
        $entities = $this->_super_repository
            ->get_all_by_where_clause($TABLE, $where_clause, $identifier);

        if (null != $entities[0])
            $entity = $entities[0];

        return $this->_construct_session_entity($entity);
    }






    private function _get_all_from__session_order_item_table(string $where_clause, $identifier): Session_Order_Items
    {
        $session_order_items = new Session_Order_Items;
        $array = [];
        $TABLE = 'session_order_item';

        $entities = $this->_super_repository->get_all_by_where_clause($TABLE, $where_clause, $identifier);


        foreach ($entities as $entity) {
            $array += [$entity['session_order_item_pk'] => $this->_construct_session_order_item_entity($entity)];
        }

        $session_order_items->set($array);
        return  $session_order_items;
    }

















































    public function insert(Session $session): bool
    {

        // Insert session into session table
        if (!($this->_insert_into__session_table($session))) {
            return false;
        }


        $sessions = $this->get_all()->get();
        usort($sessions, function ($a, $b) {
            return $a->session_pk - $b->session_pk;
        });
        $fresh_session = $sessions[array_key_last($sessions)];

        $session_pk_fk = $fresh_session->session_pk;
        $session_order_items = $session->get_session_order_items();


        foreach ($session_order_items as $session_order_item) {
            $session_order_item->session_pk_fk = $session_pk_fk;
            if (!($this->_insert_into__session_order_item_table($session_order_item))) {
                return false;
            }
        }
        return true;
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






































    public function update(int $pk, Session $session): bool
    {

        if (!($this->_update__session_table($pk, $session))) {
            return false;
        }

        $session_order_items = $session->get_session_order_items();
        foreach ($session_order_items as $session_order_item) {
            $fk = $session_order_item->session_pk_fk;
            if (!($this->_update__session_order_item_table($fk, $session_order_item))) {
                return false;
            }
        }
        return true;
    }







    private function _update__session_table(int $pk, Session $session): bool
    {
        $fields_to_ignore = ['session_pk', 'order_id', 'datetime_created', 'datetime_last_modified'];
        return $this->_super_repository
            ->update_entity(
                $object_be_updated = $session,
                $table = 'session',
                $where_clause = 'session_pk',
                $identifier = $pk,
                $fields_to_ignore
            );
    }





    private function _update__session_order_item_table(int $fk, Session_Order_Item $session_order_item): bool
    {
        return $this->_super_repository
            ->update_entity(
                $object_be_updated = $session_order_item,
                $table = 'session_order_item',
                $where_clause = 'session_pk_fk',
                $identifier = $fk
            );
    }

































































    private function _construct_session_order_item_entity(array $entity): Session_Order_Item
    {
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
            $entity['order_status_email_invoice_sent_to_customer'],
            $entity['customer_fullname'],
            $entity['customer_tos_and_tac_has_been_accepted'],
            $entity['customer_contact_email']
        );
    }
}
