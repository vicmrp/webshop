<?php

namespace vezit\repositories\super_repository;

use DateTime;
use vezit\classes\mysqli\Mysqli;
use vezit\entities\Product;

class Super_Repository
{
    private static $_times_instantiated = 0;
    private static $_times_destroyed = 0;
    private static $_instance = null;




    public static function get_instance(Mysqli $mysqli = null)
    {
        // Laver en instance hvis den ikke findes.
        // Laver en ny instance hvis get_instance bliver kaldet med parametre.
        return (null === self::$_instance) ? new Super_Repository(

            (null === $mysqli) ? Mysqli::get_instance() : $mysqli

        ) : self::$_instance;
    }

    public static function destroy_instance() : void {
        if (null !== self::$_instance) {
            self::$_times_destroyed++;
            self::$_instance = null;
        }
    }

    private function __construct(
        private Mysqli $_mysqli
    ) {
        self::$_times_instantiated++;
    }


    // -------- READ --------
    public function get_all(string $table): array
    {

        $sql = "SELECT * FROM $table";
        $stmt = $this->_mysqli->get_db_conn()->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $enitities = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $enitities;
    }




    public function get_all_by_where_clause(string $table, string $where_clause, string $identifier): array
    {



        $sql = "SELECT * FROM $table WHERE $where_clause=?";
        $stmt = $this->_mysqli->get_db_conn()->prepare($sql);

        if (!($stmt->execute([$identifier]))) {
            throw new \Exception("Could not execute statement: " . $stmt->error);
        }

        $result = $stmt->get_result();

        $entities = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $entities;
    }
    // -------- READ --------




    // -------- WRITE --------
    public function insert_entity($object_to_be_inserted, $table, array $fields_to_ignore = []): bool
    {
        //WARNING vær opmærksom pa at $fields_to_ignore maske godt kan give problemer

        $create_array_from_object_to_inserted = function () use ($object_to_be_inserted, $fields_to_ignore): array {

            // Rækkefølgen er sku vigtig!
            $array_of_property_values = [];

            foreach ($object_to_be_inserted as $key => $value) {

                // if value is the same as one of them in the fields to ignore array then pass and continue
                if (!in_array((string)$key, $fields_to_ignore)) {
                    if ($value instanceof DateTime) {
                        array_push($array_of_property_values, $value->format('Y-m-d H:i:s'));
                    }
                    else {

                        if (is_bool($value)) {
                            $value = (int)$value;
                        }

                        array_push($array_of_property_values, $value);
                    }



                }


            }


            return $array_of_property_values;
        };


        $create_sql_string_based_on_object_to_be_inserted = function () use ($object_to_be_inserted, $table, $fields_to_ignore): string {
            $sql = "INSERT INTO `$table` (";


            foreach ($object_to_be_inserted as $key => $value) {
                if (!in_array((string)$key, $fields_to_ignore))
                    $sql .= "\n\t`$key`,";
            }
            $sql = rtrim($sql, ", ");

            $sql .= ") VALUES (";

            foreach ($object_to_be_inserted as $key => $value) {
                if (!in_array((string)$key, $fields_to_ignore))
                    $sql .= "?,";
            }
            $sql = rtrim($sql, ", ") . ")";

            return $sql;
        };


        $array = $create_array_from_object_to_inserted();
        $sql = $create_sql_string_based_on_object_to_be_inserted();
        $stmt = $this->_mysqli->get_db_conn()->prepare($sql);

        if (!($stmt->execute($array))) {
            throw new \Exception("Could not execute statement: " . $stmt->error);
            $stmt->close();
            return false;
        }

        return true;
    }





    public function update_entity(
        $object_to_be_updated,
        $table,
        $where_clause,
        $identifier,
        array $fields_to_ignore = []
    ): bool {


        // For hver property skal du tilføje et spørgmal
        $create_array_from_object_to_updated = function () use ($object_to_be_updated, $identifier, $fields_to_ignore): array {

            // Rækkefølgen er sku vigtig!
            $array_of_property_values = [];
            foreach ($object_to_be_updated as $key => $value) {
                if (!in_array((string)$key, $fields_to_ignore)) {
                    if ($value instanceof DateTime) {
                        array_push($array_of_property_values, $value->format('Y-m-d H:i:s'));
                    }
                    else {

                        if (is_bool($value)) {
                            $value = (int)$value;
                        }

                        array_push($array_of_property_values, $value);
                    }



                }
            }

            array_push($array_of_property_values, $identifier);

            return $array_of_property_values;
        };


        $create_sql_string_based_on_object_to_be_updated = function () use ($object_to_be_updated, $table, $where_clause, $fields_to_ignore): string {
            $sql = "UPDATE `$table` SET";

            foreach ($object_to_be_updated as $key => $value) {
                if (!in_array((string)$key, $fields_to_ignore))
                    $sql .= "\n\t`$key` = ?,";
            }
            $sql = rtrim($sql, ", ");
            $sql .= "\n\tWHERE `$where_clause` = ?";

            return $sql;
        };


        $array = $create_array_from_object_to_updated();
        $sql = $create_sql_string_based_on_object_to_be_updated();


        $stmt = $this->_mysqli->get_db_conn()->prepare($sql);

        if (!($stmt->execute($array))) {
            throw new \Exception("Could not execute statement: " . $stmt->error);
            $stmt->close();
            return false;
        }

        return true;
    }
    // -------- WRITE --------





    // -------- DELETE --------
    // -------- DELETE --------



}
