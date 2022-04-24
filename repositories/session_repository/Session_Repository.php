<?php

namespace vezit\repositories\session_repository;

use vezit\entities\session\Session_Entity;
use vezit\classes\mysqli\Mysqli;

require __DIR__ . '/../../global-requirements.php';

class Session_Repository implements ISession_Repository
{

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

        return new Session_Entity(
            $session_pk = $array['session_pk'],
            $serialized_session = $array['serialized_session']
        );
    }


    public function insert(Session_Entity $session_entity): bool
    {


        $sql = "
        INSERT INTO `session`
        (
        `session_pk`"                                       .   // i
        ",`session_id`"                                     .   // i
        ",`customer_fullname`"                              .   // s
        ",`customer_details_satisfied_for_payment`"         .   // s
        ",`customer_address_street`"                        .   // s
        ",`customer_address_postal_code`"                   .   // i
        ",`customer_address_city`"                          .   // s
        ",`customer_contact_phone`"                         .   // i
        ",`customer_contact_email`"                         .   // s
        ",`customer_company_cvr_number`"                    .   // i
        ",`customer_company_name`"                          .   // s
        ",`order_id`"                                       .   // i
        ",`order_status_payment_accepted`"                  .   // i
        ",`order_status_payment_currency`"                  .   // s
        ",`order_status_payment_amount`"                    .   // i
        ",`order_status_payment_quickpay_id`"               .   // i
        ",`order_status_payment_details_satisfied`"         .   // i
        ",`order_status_email_confirmation_sent`"           .   // i
        ",`order_status_email_invoice_sent_to_customer`"    .   // i
        ",`shipment_tracking_number`"                       .   // i
        ",`shipment_order_collected`"                       .   // i
        ",`shipment_details_satisfied`"                     .   // i
        ",`shipment_address_street_name`"                   .   // s
        ",`shipment_address_street_number`"                 .   // s
        ",`shipment_address_postal_code`"                   .   // i
        ",`shipment_address_city`"                          .   // s
        ")  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->_mysqli->get_db_conn()->prepare($sql);
        $stmt->bind_param(
            "iisssisisisiisiiiiiiiissis",
            $session_entity->session_pk,
            $session_entity->session_id,
            $session_entity->customer_fullname,
            $session_entity->customer_details_satisfied_for_payment,
            $session_entity->customer_address_street,
            $session_entity->customer_address_postal_code,
            $session_entity->customer_address_city,
            $session_entity->customer_contact_phone,
            $session_entity->customer_contact_email,
            $session_entity->customer_company_cvr_number,
            $session_entity->customer_company_name,
            $session_entity->order_id,
            $session_entity->order_status_payment_accepted,
            $session_entity->order_status_payment_currency,
            $session_entity->order_status_payment_amount,
            $session_entity->order_status_payment_quickpay_id,
            $session_entity->order_status_payment_details_satisfied,
            $session_entity->order_status_email_confirmation_sent,
            $session_entity->order_status_email_invoice_sent_to_customer,
            $session_entity->shipment_tracking_number,
            $session_entity->shipment_order_collected,
            $session_entity->shipment_details_satisfied,
            $session_entity->shipment_address_street_name,
            $session_entity->shipment_address_street_number,
            $session_entity->shipment_address_postal_code,
            $session_entity->shipment_address_city
        );

        if($stmt->execute())
        {
            $stmt->close();
            return true;
        }
        else
        {
            $stmt->close();
            return false;
        }
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


    }


    public function delete(object $entity): void
    {
    }
}
