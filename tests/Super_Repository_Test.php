<?php

use PHPUnit\Framework\TestCase;
use vezit\classes\mysqli\Mysqli;
use vezit\repositories\super_repository\Super_Repository;

require __DIR__ . '/../global-requirements.php';
require_once 'Mysqli_Test.php';

class Super_Repository_Test extends TestCase
{

    private string $db_server = 'database';
    private string $db_user = 'testuser';
    private string $db_pass = 'Passw0rd';
    private string $db_unittest_name_prefix = 'sandbox_testuser_vezit_net_';
    private string $db_version;

    protected function setUp(): void
    {
        global $g_db_version;
        $this->db_version = $g_db_version;;
    }

    function tearDown(): void
    {
        // Destroy the Super_Repository instance so that a new connection with other creds can be made
        Super_Repository::get_instance()->destroy_instance();
    }















    /**
     * This test verifies if a Super_Repository instance can be created without errors using the unittest database credentials
     *
     * @depends Mysqli_Test::test_connection_to_database_using_unittest_credentials
     */
    public function test_connection(): void
    {
        // Create an instance of Mysqli using the unittest database credentials
        $mysqli = Mysqli::get_instance(
            $this->db_server,
            $this->db_user,
            $this->db_pass,
            $this->db_unittest_name_prefix . $this->db_version
        );

        // Create a Super_Repository instance using the Mysqli instance
        $super_repository = Super_Repository::get_instance($mysqli);

        // Verify that a Super_Repository instance was created
        $this->assertInstanceOf(Super_Repository::class, $super_repository);
    }















    /** 
     * @depends test_connection
     */
    public function test_insert_entity(): void
    {
        // Destroy the Super_Repository instance so that a new connection with other creds can be made
        Super_Repository::get_instance()->destroy_instance();


        // Create an instance of Mysqli using the unittest database credentials
        $mysqli = Mysqli::get_instance(
            $this->db_server,
            $this->db_user,
            $this->db_pass,
            $this->db_unittest_name_prefix . $this->db_version
        );



        $order = new stdClass();
        $order->order_id = g_generate_random_string(20);
        $order->anonymous = false;
        $order->order_status_payment_currency = "DKK";
        $order->order_status_payment_total_amount = 14900;
        $order->order_status_payment_quickpay_id = "123";
        $order->order_status_email_invoice_and_product_sent_to_customer = true;
        $order->customer_fullname = "John Doe";
        $order->customer_tos_and_tac_has_been_accepted = true;
        $order->customer_contact_email = "john.doe@example.com";


        // Create a Super_Repository instance using the Mysqli instance
        $super_repository = Super_Repository::get_instance($mysqli);


        // These field must come is the same order as they are defined in the database
        $field_that_should_be_ignored = ['pk', 'datetime_created', 'datetime_modified'];
        $result = $super_repository->insert_entity($order, 'orders', $field_that_should_be_ignored);

        $this->assertTrue($result);
    }

















    /**
     * @depends test_insert_entity
     */
    public function test_get_all(): void
    {
        // Create an instance of Mysqli using the unittest database credentials
        $mysqli = Mysqli::get_instance(
            $this->db_server,
            $this->db_user,
            $this->db_pass,
            $this->db_unittest_name_prefix . $this->db_version
        );

        // Create a Super_Repository instance using the Mysqli instance
        $super_repository = Super_Repository::get_instance($mysqli);

        // Retrieve all rows data from the "orders" table
        $result = $super_repository->get_all("orders");

        // Assert that the result is an array
        $this->assertIsArray($result);

        // Assert that the result is not empty
        $this->assertNotEmpty($result);
    }























    /** 
     * @depends test_connection
     * @depends test_insert_entity
     */
    public function test_get_all_by_where_clause(): void
    {
        // Create an instance of Mysqli using the unittest database credentials
        $mysqli = Mysqli::get_instance(
            $this->db_server,
            $this->db_user,
            $this->db_pass,
            $this->db_unittest_name_prefix . $this->db_version
        );

        // Create a Super_Repository instance using the Mysqli instance
        $super_repository = Super_Repository::get_instance($mysqli);

        // Insert an order to the database
        $order = new stdClass();
        $order->order_id = g_generate_random_string(20);
        $order->datetime_created = "2022-02-23 12:00:00";
        $order->datetime_modified = "2022-02-23 12:00:00";
        $order->anonymous = false;
        $order->order_status_payment_currency = "DKK";
        $order->order_status_payment_total_amount = 14900;
        $order->order_status_payment_quickpay_id = "123";
        $order->order_status_email_invoice_and_product_sent_to_customer = true;
        $order->customer_fullname = "John Doe";
        $order->customer_tos_and_tac_has_been_accepted = true;
        $order->customer_contact_email = "john.doe@example.com";

        $field_that_should_be_ignored = ['pk', 'datetime_created', 'datetime_modified'];
        $super_repository->insert_entity($order, 'orders', $field_that_should_be_ignored);

        // Retrieve the order from the database
        $identifier = $order->order_id;
        $entities = $super_repository->get_all_by_where_clause('orders', 'order_id', $identifier);

        // Verify that the order was retrieved successfully
        $this->assertIsArray($entities);
        $this->assertNotEmpty($entities);

        $retrieved_order = $entities[0];
        $this->assertEquals($order->order_id, $retrieved_order['order_id']);
        $this->assertEquals($order->order_status_payment_currency, $retrieved_order['order_status_payment_currency']);
        $this->assertEquals($order->order_status_payment_total_amount, $retrieved_order['order_status_payment_total_amount']);
        $this->assertEquals($order->order_status_payment_quickpay_id, $retrieved_order['order_status_payment_quickpay_id']);
        $this->assertEquals($order->order_status_email_invoice_and_product_sent_to_customer, $retrieved_order['order_status_email_invoice_and_product_sent_to_customer']);
        $this->assertEquals($order->customer_fullname, $retrieved_order['customer_fullname']);
        $this->assertEquals($order->customer_tos_and_tac_has_been_accepted, $retrieved_order['customer_tos_and_tac_has_been_accepted']);
        $this->assertEquals($order->customer_contact_email, $retrieved_order['customer_contact_email']);
    }







































/**
     * @depends test_connection
     * @depends test_insert_entity
     * @depends test_get_all
     * 
     */
    public function test_update_entity(): void
    {
        // Create an instance of Mysqli using the unittest database credentials
        $mysqli = Mysqli::get_instance(
            $this->db_server,
            $this->db_user,
            $this->db_pass,
            $this->db_unittest_name_prefix . $this->db_version
        );

        // Create a Super_Repository instance using the Mysqli instance
        $super_repository = Super_Repository::get_instance($mysqli);

        // Retrieve the inserted object from the previous test
        $orders = $super_repository->get_all('orders');
        $order = (object)end($orders);

        // Update the order
        $order->order_status_payment_currency = 'EUR';
        $order->customer_fullname = 'Jane Doe';
        $result = $super_repository->update_entity($order, 'orders', 'order_id', $order->order_id, ['pk', 'datetime_created', 'datetime_modified']);

        $this->assertTrue($result);

        // Retrieve the updated object from the database
        $updated_orders = $super_repository->get_all('orders');
        $updated_order = (object)end($updated_orders);

        // Check that the updated properties have been changed in the database
        $this->assertEquals('EUR', $updated_order->order_status_payment_currency);
        $this->assertEquals('Jane Doe', $updated_order->customer_fullname);
    }
}
