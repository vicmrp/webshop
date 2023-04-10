<?php

namespace vezit\repositories\order_repository;

require __DIR__ . '/../../global-requirements.php';

use vezit\repositories\super_repository\Super_Repository;
use vezit\entities\Order;
use vezit\entities\Orders;

// This is a repository class and is responsible for all database interaction with the order table.
// It is a singleton class and should be instantiated using the get_instance() method.



class Order_Repository
{


    // ----------- SINGLETON PATTERN STARTS HERE ------------- //
    private static int $_times_instantiated = 0;
    private static int $_times_destroyed = 0;
    private static $_instance = null;

    public static function get_instance(Super_Repository $super_repository = null)
    {
        return (null === self::$_instance) ? new Order_Repository(

            (null === $super_repository) ? Super_Repository::get_instance() : $super_repository

        ) : self::$_instance;
    }


    private function __construct(
        private Super_Repository $_super_repository
    ) {
        self::$_times_instantiated++;
    }

    // Destroy the current instance of the Super_Repository class
    public static function destroy_instance(): void
    {
        if (null !== self::$_instance) {
            self::$_times_destroyed++;
            self::$_instance = null;
        }
    }

    // ------------ SINGLETON PATTERN ENDS HERE -------------- //



    // --------------- PUBLIC METHODS START HERE --------------- //

    // The $associative_key_foreach_object is the key that you can you use to access each object in the associative array 
    // For example:
    // $orders = $order_repository->get_all('order_id');
    //
    // $order_id = '123456';
    // $order = $orders->get()[$order_id] // returns an Order object
    public function get_all($associative_key_foreach_object = 'order_id'): Orders
    {
        $orders = $this->_get_all_from__order_table($associative_key_foreach_object);

        return $orders;
    }













    public function insert(Order $order): void
    {
        $this->_insert_into__order_table($order);
    }








































    // --------------- PUBLIC METHODS END HERE --------------- //


    // --------------- PRIVATE METHODS START HERE --------------- //


    private function _insert_into__order_table(Order $order): void
    {
        // Ignores these field because they created by the database
        $fields_to_ignore = ['pk', 'datetime_created', 'datetime_modified'];
        $this->_super_repository->insert_entity($object_to_be_inserted = $order, $table = "orders", $fields_to_ignore = $fields_to_ignore);
    }


























    private function _get_all_from__order_table(string $associative_key_foreach_object): Orders
    {
        $raw_entitities = $this->_super_repository->get_all($table = "orders");

        $orders = new Orders();
        $orders_objects = [];
        
        // Convert the raw entities to Order objects
        array_walk($raw_entitities, function ($raw_entity) use (&$orders_objects, $associative_key_foreach_object): void {
            $orders_objects[$raw_entity[$associative_key_foreach_object]] = $this->_construct_order_object_from_raw_entity($raw_entity);
        });

        // Put the order_objects into the Orders object
        $orders->set($orders_objects);

        return $orders;
    }





































    private function _construct_order_object_from_raw_entity($raw_entity): Order
    {
        $datetime_created = \DateTime::createFromFormat('Y-m-d H:i:s', $raw_entity['datetime_created']);
        $datetime_modified = \DateTime::createFromFormat('Y-m-d H:i:s', $raw_entity['datetime_modified']);
    
        $order = new Order(
            $pk = $raw_entity['pk'],
            $order_id = $raw_entity['order_id'],
            $datetime_created = $datetime_created,
            $datetime_modified = $datetime_modified,
            $anonymous = $raw_entity['anonymous'],
            $order_status_payment_currency = $raw_entity['order_status_payment_currency'],
            $order_status_payment_total_amount = $raw_entity['order_status_payment_total_amount'],
            $order_status_payment_quickpay_id = $raw_entity['order_status_payment_quickpay_id'],
            $order_status_email_invoice_and_product_sent_to_customer = $raw_entity['order_status_email_invoice_and_product_sent_to_customer'],
            $customer_fullname = $raw_entity['customer_fullname'],
            $customer_tos_and_tac_has_been_accepted = $raw_entity['customer_tos_and_tac_has_been_accepted'],
            $customer_contact_email = $raw_entity['customer_contact_email'],
        );
    
        return $order;
    }

    // --------------- PRIVATE METHODS END HERE --------------- //

}
