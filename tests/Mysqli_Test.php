<?php

use vezit\classes\mysqli\Mysqli;

require __DIR__ . '/../global-requirements.php';

use PHPUnit\Framework\TestCase;

class Mysqli_Test extends TestCase
{

    private string $db_server = 'database-service';
    private string $db_user = 'testuser';
    private string $db_pass = 'Passw0rd';
    private string $db_sandbox_name_prefix = 'sandbox_testuser_vezit_net_';
    private string $db_unittest_name_prefix = 'unittest_testuser_vezit_net_';
    private string $db_version;

    protected function setUp(): void
    {
        global $g_db_version;
        $this->db_version = $g_db_version;;
    }

    function tearDown(): void
    {
        // Destroy the Mysqli instance so that a new connection with other creds can be made
        Mysqli::get_instance()->destroy_instance();
    }

    /**
     * This test checks if the database connection with sandbox credentials is successful or not
     */
    public function test_connection_to_database_using_sandbox_credentials()
    {
        $mysqli = Mysqli::get_instance(
            $this->db_server,
            $this->db_user,
            $this->db_pass,
            $this->db_sandbox_name_prefix . $this->db_version
        );

        $this->assertInstanceOf(\mysqli::class, $mysqli->get_db_conn());
    }

    /**
     * This test checks if the database connection with unittest credentials is successful or not
     */
    public function test_connection_to_database_using_unittest_credentials()
    {
        $mysqli = Mysqli::get_instance(
            $this->db_server,
            $this->db_user,
            $this->db_pass,
            $this->db_unittest_name_prefix . $this->db_version
        );

        $this->assertInstanceOf(\mysqli::class, $mysqli->get_db_conn());
    }



    /**
     * This test checks if the database connection with non-existing database credentials fails
     */
    public function test_connection_to_non_existing_database()
    {
        // Attempt to create an instance of Mysqli with non-existing database credentials
        try {
            $mysqli = Mysqli::get_instance(
                $this->db_server,
                $this->db_user,
                $this->db_pass,
                'non_existing_database'
            );
        } catch (\Exception $e) {
            // If an exception is thrown, verify that it is a mysqli_sql_exception
            $type = get_class($e);
            $this->assertEquals("mysqli_sql_exception", $type);

            // Verify that the error message indicates an access denied error
            $sub_string = substr($e->getMessage(), 0, 40);
            $this->assertEquals("Access denied for user 'testuser'@'%' to", $sub_string);
            return;
        }

        // If no exception is thrown, then the test fails
        $this->fail("Expected exception not thrown");
    }


    /**
     * This test checks if the database connection fails when global connection is missing
     */
    public function test_connection_with_missing_global_connection()
    {
        // Save the current global connection in a temporary variable
        global $g_db_conn;
        $temp_db_conn = $g_db_conn;

        // Set the global connection to null
        $g_db_conn = null;

        try {
            // Attempt to create an instance of Mysqli without passing any database credentials
            $mysqli = Mysqli::get_instance();
        } catch (\Exception $e) {
            // Restore the original global connection
            $g_db_conn = $temp_db_conn;

            // Verify that the exception type is 'Exception'
            $type = get_class($e);
            $this->assertEquals("Exception", $type);

            // Verify that the error message indicates a connection error
            $message = $e->getMessage();
            $this->assertEquals("Global connection is not set", $message);
            return;
        }

        // Restore the original global connection
        $g_db_conn = $temp_db_conn;

        // If no exception is thrown, then the test fails
        $this->fail("Expected exception not thrown");
    }
}
