<?php

namespace vezit\repositories\super_repository;

use DateTime;
use vezit\classes\mysqli\Mysqli;
use vezit\classes\error\Error;
use vezit\entities\Product;

class Super_Repository
{

    // ------------ SINGLETON PATTERN ENDS HERE -------------- //
    // Maintain a count of times instantiated and destroyed
    private static int $_times_instantiated = 0;
    private static int $_times_destroyed = 0;

    // Singleton instance of the class
    private static ?Super_Repository $_instance = null;

    // Private constructor to prevent direct instantiation
    private function __construct(private Mysqli $_mysqli)
    {
        self::$_times_instantiated++;
    }

    // Get an instance of the Super_Repository class
    public static function get_instance(Mysqli $mysqli = null): Super_Repository
    {
        if (null === self::$_instance) {
            // Create a new instance with the given mysqli object, or the default mysqli instance
            self::$_instance = new self($mysqli ?? Mysqli::get_instance());
        }

        return self::$_instance;
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

    // -------- TEST Connection -------- //
    public function test_connection(?string $dbname = null): bool
    {
        // defaults to global database name
        if (null === $dbname) {
            global $g_db_conn;
            $dbname = $g_db_conn->dbname;
        }

        try {
            if ($this->_mysqli->get_db_conn()->select_db($dbname)) {
                // Connected to database successfully!
                return true;
            } else {
                // Failed to connect to database!
                return false;
            }
        } catch (\Exception $e) {
            // Determine if the execution is coming from a unit test
            $trace = debug_backtrace();
            $is_unit_test = false;
            foreach ($trace as $step) {
                if (isset($step['class']) && strpos($step['class'], 'PHPUnit\\') === 0) {
                    $is_unit_test = true;
                    break;
                }
            }

            // Log the error message if it's not a unit test
            if (!$is_unit_test) {
                Error::log($e->getMessage() . ' ' . $e->getTraceAsString());
            }

            // Rethrow the exception
            throw $e;
        }
    }
    // -------- TEST Connection -------- //

    // -------- READ -------- // 
    /**
     * This function retrieves all rows from a specified database table
     * @param string $table The name of the table to retrieve data from
     * @return array An array of associative arrays representing each row in the table
     */
    public function get_all(string $table_name): array
    {
        // Construct the SQL query to retrieve all data from the specified table
        $sql = "SELECT * FROM $table_name";

        // Prepare the query statement using the database connection
        $stmt = $this->_mysqli->get_db_conn()->prepare($sql);

        // Execute the query and get the result set
        $stmt->execute();
        $result = $stmt->get_result();

        // Convert the result set into an array of associative arrays
        $enitities = $result->fetch_all(MYSQLI_ASSOC);

        // Close the statement
        $stmt->close();

        // Return the array of data
        return $enitities;
    }




    public function get_all_by_where_clause(string $table, string $where_clause, string $identifier): array
    {
        // Create the SQL query using the provided table, where clause, and identifier
        $sql = "SELECT * FROM $table WHERE $where_clause=?";
    
        // Prepare the statement using the mysqli connection and the SQL query
        $stmt = $this->_mysqli->get_db_conn()->prepare($sql);
    
        // If the statement cannot be executed, throw an exception with the error message
        if (!($stmt->execute([$identifier]))) {
            throw new \Exception("Could not execute statement: " . $stmt->error);
        }
    
        // Get the result of the executed statement
        $result = $stmt->get_result();
    
        // Fetch all the results as an associative array
        $entities = $result->fetch_all(MYSQLI_ASSOC);
    
        // Close the statement
        $stmt->close();
    
        // Return the fetched entities
        return $entities;
    }
    // -------- READ -------- //




    // -------- WRITE -------- //
    public function insert_entity(object $entity, string $table, array $fields_to_ignore = []): bool
    {
        // Define a closure to extract the properties of the entity to be inserted into an array
        $create_array_of_property_values = function () use ($entity, $fields_to_ignore): array {
            $property_values = [];
    
            // Loop through each property of the entity
            foreach ($entity as $property_name => $property_value) {
    
                // Check if the property should be ignored
                if (in_array($property_name, $fields_to_ignore)) {
                    continue;
                }
    
                // Format the property value if it's a boolean or a DateTime object
                if (is_bool($property_value)) {
                    $property_value = (int)$property_value;
                } elseif ($property_value instanceof DateTime) {
                    $property_value = $property_value->format('Y-m-d H:i:s');
                }
    
                // Add the property value to the array
                $property_values[] = $property_value;
            }
    
            return $property_values;
        };
    
        // Define a closure to create an SQL INSERT statement for the entity
        $create_insert_sql_statement = function () use ($entity, $table, $fields_to_ignore): string {
            $sql = "INSERT INTO `$table` (";
    
            // Loop through each property of the entity and add its name to the SQL statement if it should not be ignored
            foreach ($entity as $property_name => $property_value) {
                if (!in_array($property_name, $fields_to_ignore)) {
                    $sql .= "`$property_name`, ";
                }
            }
            $sql = rtrim($sql, ', ') . ') VALUES (';
    
            // Add placeholders for each property of the entity that should not be ignored
            foreach ($entity as $property_name => $property_value) {
                if (!in_array($property_name, $fields_to_ignore)) {
                    $sql .= '?, ';
                }
            }
            $sql = rtrim($sql, ', ') . ')';
    
            return $sql;
        };
    
        // Execute the prepared statement using the entity's properties and return true if successful
        $property_values = $create_array_of_property_values();
        $insert_sql_statement = $create_insert_sql_statement();
        $stmt = $this->_mysqli->get_db_conn()->prepare($insert_sql_statement);
    
        if (!$stmt->execute($property_values)) {
            $error_message = "Could not execute statement: " . $stmt->error;
            $stmt->close();
            throw new \Exception($error_message);
            return false;
        }
    
        return true;
    }




    public function update_entity(
        object $object_to_be_updated,
        string $table,
        string $where_clause,
        string $identifier,
        array $fields_to_ignore = []): bool {
    
        // A function that creates an array of property values to be updated for the object
        $create_array_from_object_to_be_updated = function () use ($object_to_be_updated, $identifier, $fields_to_ignore): array {
            $array_of_property_values = [];
    
            // For each property in the object, add a placeholder for a value to be updated
            foreach ($object_to_be_updated as $key => $value) {
                if (!in_array((string)$key, $fields_to_ignore)) {
                    // If the value is a DateTime object, format it as a string
                    if ($value instanceof DateTime) {
                        array_push($array_of_property_values, $value->format('Y-m-d H:i:s'));
                    } else {
                        // If the value is a boolean, convert it to an integer
                        if (is_bool($value)) {
                            $value = (int)$value;
                        }
                        // Add the value to the array of property values to be updated
                        array_push($array_of_property_values, $value);
                    }
                }
            }
    
            // Add the identifier value to the end of the array of property values
            array_push($array_of_property_values, $identifier);
    
            return $array_of_property_values;
        };
    
        // A function that creates the SQL string for the update query
        $create_sql_string_based_on_object_to_be_updated = function () use ($object_to_be_updated, $table, $where_clause, $fields_to_ignore): string {
            $sql = "UPDATE `$table` SET";
    
            // For each property in the object, add a placeholder for a value to be updated in the SET clause of the query
            foreach ($object_to_be_updated as $key => $value) {
                if (!in_array((string)$key, $fields_to_ignore)) {
                    $sql .= "\n\t`$key` = ?,";
                }
            }
            $sql = rtrim($sql, ", ");
            $sql .= "\n\tWHERE `$where_clause` = ?";
    
            return $sql;
        };
    
        $array_of_property_values = $create_array_from_object_to_be_updated();
        $sql = $create_sql_string_based_on_object_to_be_updated();
    
        $stmt = $this->_mysqli->get_db_conn()->prepare($sql);
    
        if (!($stmt->execute($array_of_property_values))) {
            throw new \Exception("Could not execute statement: " . $stmt->error);
            $stmt->close();
            return false;
        }
    
        return true;
    }
    // -------- WRITE -------- //





    // -------- DELETE -------- //
    // -------- DELETE -------- //

    // --------------- PUBLIC METHODS END HERE --------------- //


}
