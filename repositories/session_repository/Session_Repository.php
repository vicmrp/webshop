<?php

namespace vezit\repositories\session_repository;

use vezit\dto\session as DTO;
use vezit\entities\class\order\item\Item;
use vezit\entities\session\Session;
use vezit\classes\mysqli\Mysqli;

require __DIR__ . '/../../global-requirements.php';

class Session_Repository implements ISession_Repository
{

    public function __construct(private $_mysqli = new Mysqli)
    {}

    public function get_all(): array
    {
        $sql = "SELECT * FROM `session`";
        $stmt = $this->_mysqli->get_db_conn()->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $entities = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        $sessions = [];
        foreach ($entities as $entity) {
            $sessions[] = $this->session($entity);
        }

        return $sessions;
    }

    public function find_by_pk(int $session_pk): Session
    {

        $sql = "SELECT * FROM `session` WHERE session_pk=?";
        $stmt = $this->_mysqli->get_db_conn()->prepare($sql);
        $stmt->bind_param("i", $session_pk);
        $stmt->execute();
        $result = $stmt->get_result();
        $entity = $result->fetch_assoc();
        $stmt->close();

        return $this->session($entity);
    }

    public function find_by_order_id(int $order_id): Session
    {

        $sql = "SELECT * FROM `session` WHERE order_id=?";
        $stmt = $this->_mysqli->get_db_conn()->prepare($sql);
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $entity = $result->fetch_assoc();
        $stmt->close();

        return $this->session($entity);
    }








    public function insert(DTO\Session $session): bool
    {


        $sql = "
        INSERT INTO `session`
        ("                                                  .
        "`order_id`"                                        .   // i
        ",`order_status_payment_accepted`"                  .   // i
        ",`order_status_payment_currency`"                  .   // s
        ",`order_status_payment_amount`"                    .   // i
        ",`order_status_payment_quickpay_id`"               .   // i
        ",`order_status_payment_details_satisfied`"         .   // i
        ",`order_status_email_confirmation_sent`"           .   // i
        ",`order_status_email_invoice_sent_to_customer`"    .   // i
        ",`customer_fullname`"                              .   // s
        ",`customer_details_satisfied_for_payment`"         .   // s
        ",`customer_address_street`"                        .   // s
        ",`customer_address_postal_code`"                   .   // i
        ",`customer_address_city`"                          .   // s
        ",`customer_contact_phone`"                         .   // i
        ",`customer_contact_email`"                         .   // s
        ",`customer_company_cvr_number`"                    .   // i
        ",`customer_company_name`"                          .   // s
        ",`shipment_tracking_number`"                       .   // i
        ",`shipment_order_collected`"                       .   // i
        ",`shipment_details_satisfied`"                     .   // i
        ",`shipment_address_street_name`"                   .   // s
        ",`shipment_address_street_number`"                 .   // s
        ",`shipment_address_postal_code`"                   .   // i
        ",`shipment_address_city`"                          .   // s
        ")  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->_mysqli->get_db_conn()->prepare($sql);
        $stmt->bind_param(
            "iisiiiiisssisisisiiissis",

            $session->order_id,
            $session->order_status_payment_accepted,
            $session->order_status_payment_currency,
            $session->order_status_payment_amount,
            $session->order_status_payment_quickpay_id,
            $session->order_status_payment_details_satisfied,
            $session->order_status_email_confirmation_sent,
            $session->order_status_email_invoice_sent_to_customer,
            $session->customer_fullname,
            $session->customer_details_satisfied_for_payment,
            $session->customer_address_street,
            $session->customer_address_postal_code,
            $session->customer_address_city,
            $session->customer_contact_phone,
            $session->customer_contact_email,
            $session->customer_company_cvr_number,
            $session->customer_company_name,
            $session->shipment_tracking_number,
            $session->shipment_order_collected,
            $session->shipment_details_satisfied,
            $session->shipment_address_street_name,
            $session->shipment_address_street_number,
            $session->shipment_address_postal_code,
            $session->shipment_address_city
        );


        if(!($stmt->execute()))
        {
            throw new \Exception("Could not execute statement: " . $stmt->error);
            $stmt->close();
            return false;
        }

        $items = $session_entity->get_order_items();
        array_walk($items, function($item)
        {
            $sql = "
            INSERT INTO `session_order_items`
            ("                                       .
            "`order_id`"                             .   // i
            ",`product_id`"                          .   // i
            ",`product_name`"                        .   // s
            ",`price`"                               .   // i
            ",`quantity`"                            .   // i
            ")  VALUES (?, ?, ?, ?, ?)";



            $stmt2 = $this->_mysqli->get_db_conn()->prepare($sql);
            $stmt2->bind_param(
                "iissi",
                $item->order_id,
                $item->product_id,
                $item->product_name,
                $item->price,
                $item->quantity
            );

            if(!($stmt2->execute()))
            {
                throw new \Exception("Could not execute statement: " . $stmt2->error);
                $stmt2->close();
                return false;
            }
        });

        return true;
    }


    public function update(): void
    {



    }


    public function delete(): void
    {
    }











    private function session(array $entity): Session
    {
        return new Session(
            $entity['session_pk'],
            $entity['order_id'],
            $entity['order_status_payment_accepted'],
            $entity['order_status_payment_currency'],
            $entity['order_status_payment_amount'],
            $entity['order_status_payment_quickpay_id'],
            $entity['order_status_payment_details_satisfied'],
            $entity['order_status_email_confirmation_sent'],
            $entity['order_status_email_invoice_sent_to_customer'],
            $entity['customer_fullname'],
            $entity['customer_details_satisfied_for_payment'],
            $entity['customer_address_street'],
            $entity['customer_address_postal_code'],
            $entity['customer_address_city'],
            $entity['customer_contact_phone'],
            $entity['customer_contact_email'],
            $entity['customer_company_cvr_number'],
            $entity['customer_company_name'],
            $entity['shipment_tracking_number'],
            $entity['shipment_order_collected'],
            $entity['shipment_details_satisfied'],
            $entity['shipment_address_street_name'],
            $entity['shipment_address_street_number'],
            $entity['shipment_address_postal_code'],
            $entity['shipment_address_city']
        );
    }
}
