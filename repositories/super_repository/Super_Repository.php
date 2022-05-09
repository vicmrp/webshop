<?php namespace vezit\repositories\super_repository;

use vezit\classes\mysqli\Mysqli;
use vezit\entities\Product;

class Super_Repository
{
    public function __construct(
        private $_mysqli = new Mysqli
        ) {}


    // -------- READ --------
    public function get_all(string $table) : array {

        $sql = "SELECT * FROM $table";
        $stmt = $this->_mysqli->get_db_conn()->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $enitities = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $enitities;
    }

    public function get_one_entity(string $table, string $where_clause, string $identifier) : array {



        $sql = "SELECT * FROM $table WHERE $where_clause=?";
        $stmt = $this->_mysqli->get_db_conn()->prepare($sql);

        if(!($stmt->execute([$identifier])))
        {
            throw new \Exception("Could not execute statement: " . $stmt->error);
        }

        $result = $stmt->get_result();

        if($result->num_rows == 0)
        {
            throw new \Exception("Could not find Product with id: " . $identifier);
        }

        $entity = $result->fetch_assoc();
        $stmt->close();

        return $entity;
    }
    // -------- READ --------




    // -------- WRITE --------
    public function update_entity($object_to_be_updated, $table, $where_clause, $identifier) : void {


        // For hver property skal du tilføje et spørgmal
        $create_array_from_object_to_updated = function() use ($object_to_be_updated) : array {

            // Rækkefølgen er sku vigtig!
            $array_of_property_values = [];
            foreach ($object_to_be_updated as $value) {
                array_push($array_of_property_values, $value);
            }
            return $array_of_property_values;
        };


        $create_sql_string_based_on_object_to_be_updated = function () use ($object_to_be_updated, $table, $where_clause, $identifier) : string {
            $sql = "UPDATE `$table` SET";

            foreach ($object_to_be_updated as $key => $value) {
                $sql .= "\n\t`$key` = ?,";
            }
            $sql = rtrim($sql, ", ");
            $sql .= "\n\tWHERE `$where_clause` = ?";

            return $sql;
        };


        $array = $create_array_from_object_to_updated();
        array_push($array, $identifier);
        $sql = $create_sql_string_based_on_object_to_be_updated();


        $stmt = $this->_mysqli->get_db_conn()->prepare($sql);
        if(!($stmt->execute($array)))
            throw new \Exception("Could not execute statement: " . $stmt->error);
        $stmt->close();

    }
    // -------- WRITE --------





    // -------- DELETE --------
    public function delete_entity_from_table($table, $where_clause, $bind_param,  $identifier) : bool {
        $sql = "SELECT * FROM $table WHERE $where_clause=?";
        $stmt = $this->_mysqli->get_db_conn()->prepare($sql);
        $stmt->bind_param($bind_param, $identifier);

        if(!($stmt->execute()))
        {

            throw new \Exception("Could not execute statement: " . $stmt->error);

            $stmt->close();
            return false;
        } else
        {

            $stmt->close();
            return true;
        }

    }
    // -------- DELETE --------



}

