<?php

namespace vezit\repositories\session_repository;

use vezit\entities\session\Session_Entity;
use vezit\dto\session\Session;
use vezit\classes\mysqli\Mysqli;

require __DIR__ . '/../../global-requirements.php';

class Session_Repository implements ISession_Repository
{


    // private function _decode_session_entity(array $array): Session_Entity
    // {
    //     $entity = json_decode($array['session_json']);

    //     $session_entity = new Session_Entity(
    //         $session_pk = $array['session_pk'],
    //         $customer = new Customer($entity->customer)
    //     );
    //     $session_entity->session_pk = $entity['session_pk'];



    //     // $session_entity->customer->fullname = $obj->session->customer->fullname;
    //     // $session_entity->customer->customer_details_satisfied_for_payment = $obj->session->customer->customer_details_satisfied_for_payment;


    //     return $session_entity;
    // }

    public function __construct(private $_mysqli = new Mysqli)
    {}


    public function find(int $session_pk): Session_Entity
    {

        $sql = "SELECT * FROM `session` WHERE session_pk=?";
        $stmt = $this->_mysqli->get_db_conn()->prepare($sql);
        $stmt->bind_param("i", $session_pk);
        $stmt->execute();
        $result = $stmt->get_result();
        $array = $result->fetch_assoc();
        $stmt->close();

        // dd($array);

        return new Session_Entity(
            $session_pk = $array['session_pk'],
            $serialized_session = $array['serialized_session']
        );
    }


    public function insert(Session_Entity $session_entity): void
    {
        $sql = "INSERT INTO `session` (`serialized_session`) VALUES (?)";
        $stmt = $this->_mysqli->get_db_conn()->prepare($sql);
        $stmt->bind_param("s", $session_entity->serialized_session);
        $stmt->execute();
        $stmt->close();
    }


    public function update(string $session_id, object $payment): void
    {

        if ($payment->accepted) {
            $json = file_get_contents(_from_top_folder() . "/_temp_database/session/$session_id.json");

            $session = json_decode($json);
            $session->order->order_status->payment->accepted = true;

            $json = json_encode($session, JSON_PRETTY_PRINT);

            unlink(_from_top_folder() . "/_temp_database/session/$session_id.json");

            file_put_contents(_from_top_folder() . "/_temp_database/session/$session_id.json", $json);
        }

        // if entity has accepted move to accepted

        // $accepted =

    }


    public function delete(object $entity): void
    {
    }
}
