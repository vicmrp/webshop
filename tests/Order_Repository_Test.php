<?php

use PHPUnit\Framework\TestCase;
use vezit\repositories\order_repository\Order_Repository;
use vezit\entities\Order;
use vezit\classes\mysqli\Mysqli;
use vezit\repositories\super_repository\Super_Repository;

require __DIR__ . '/../global-requirements.php';
require_once 'Super_Repository_Test.php';

class Order_Repository_Test extends TestCase
{

    private string $db_server = 'database-service';
    private string $db_user = 'testuser';
    private string $db_pass = 'Passw0rd';
    private string $db_unittest_name_prefix = 'unittest_testuser_vezit_net_';
    private string $db_version;

    protected function setUp(): void
    {
        global $g_db_version;
        $this->db_version = $g_db_version;;
    }

    protected function tearDown(): void
    {
        // Destroy the Super_Repository instance so that a new connection with other creds can be made
        Order_Repository::get_instance()->destroy_instance();
        Super_Repository::get_instance()->destroy_instance();
    }

    /**
     * This test checks if the Order_Repository instance can be created without errors
     *
     * @depends Super_Repository_Test::test_connection
     */
    public function test_instantiation(): void
    {
        // Attempt to create an instance of the Order_Repository
        $order_repository = Order_Repository::get_instance();

        // Assert that the instance is of type Order_Repository
        $this->assertInstanceOf(Order_Repository::class, $order_repository);
    }


    /**
     * This test check if the Order can be inserted into the db.
     * 
     */
    public function test_insert_entity(): void
    {
        // Destroy the Order_Repository instance so that a new connection with other creds can be made
        Order_Repository::get_instance()->destroy_instance();
        Super_Repository::get_instance()->destroy_instance();


        // Create an instance of Mysqli using the unittest database credentials
        $mysqli = Mysqli::get_instance(
            $this->db_server,
            $this->db_user,
            $this->db_pass,
            $this->db_unittest_name_prefix . $this->db_version
        );

        // Create a Super_Repository instance using the Mysqli instance
        $super_repository = Super_Repository::get_instance($mysqli);
        // Create a Order_Repository instance using the Mysqli instance
        $order_repository = Order_Repository::get_instance($super_repository);





        $order = new Order();
        $order->order_id = g_generate_random_string(20);
        $order->anonymous = false;
        $order->order_status_payment_currency = "DKK";
        $order->order_status_payment_total_amount = 14900;
        $order->order_status_payment_quickpay_id = "123";
        $order->order_status_email_invoice_and_product_sent_to_customer = true;
        $order->customer_fullname = "John Doe";
        $order->customer_tos_and_tac_has_been_accepted = true;
        $order->customer_contact_email = "john.doe@example.com";

        // Attempt to create an instance of the Order_Repository
        $order_repository = Order_Repository::get_instance();

        $order_repository->insert($order);

        $orders = $order_repository->get_all()->get();


        $inserted_order = g_find_object_by_id($order->order_id, $orders);

        // Assert that the instance is of type Order_Repository
        $this->assertInstanceOf(Order::class, $inserted_order);

        // Check inserted order has the same values as the original order
        $this->assertEquals($order->order_id, $inserted_order->order_id);
        $this->assertEquals($order->order_status_payment_currency, $inserted_order->order_status_payment_currency);
        $this->assertEquals($order->order_status_payment_total_amount, $inserted_order->order_status_payment_total_amount);
        $this->assertEquals($order->order_status_payment_quickpay_id, $inserted_order->order_status_payment_quickpay_id);
        $this->assertEquals($order->order_status_email_invoice_and_product_sent_to_customer, $inserted_order->order_status_email_invoice_and_product_sent_to_customer);
        $this->assertEquals($order->customer_fullname, $inserted_order->customer_fullname);
        $this->assertEquals($order->customer_tos_and_tac_has_been_accepted, $inserted_order->customer_tos_and_tac_has_been_accepted);
        $this->assertEquals($order->customer_contact_email, $inserted_order->customer_contact_email);
        
    }

    
}
