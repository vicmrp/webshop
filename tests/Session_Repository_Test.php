<?php
require __DIR__ . '/../global-requirements.php';




use \PHPUnit\Framework\TestCase;
use vezit\entities\Session;
use vezit\repositories\session_repository\Session_Repository;
use vezit\classes\mysqli\Mysqli;

class Session_Repository_Test extends TestCase
{
    protected function setUp() : void
    {
        $this->session_repository = new Session_Repository(new Mysqli('localhost', 'test', 'Passw0rd', 'test_user_v6_vezit_webshop'));
    }


    /** @test */
    public function _get_all_from_session_table__shall_return_correct_type()
    {
        // Act
        $array_of_sessions = $this->session_repository->_get_all_from_session_table();

        // Assert
        foreach ($array_of_sessions as $session) {
            if (!($session instanceof Session)) {
                $this->fail('Session_Repository::get_all() shall return an array of Session_Entity objects');
            }
        }

        $this->assertIsArray($array_of_sessions);
    }







    /** @test */
    public function _find_by_pk_from_session_table__shall_return_correct_type()
    {
        // Setup
        $array_of_session = $this->session_repository->_get_all_from_session_table();
        $session_pk = $array_of_session[0]->session_pk;

        // Assert
        $this->assertInstanceOf(Session::class, $this->session_repository->_find_by_pk_from_session_table($session_pk));
    }








    /** @test */
    public function _find_by_order_id_from_session_table__shall_return_correct_type()
    {
        // Setup
        $array_of_session = $this->session_repository->_get_all_from_session_table();
        $order_id = $array_of_session[0]->order_id;

        // Act
        $session_entity = $this->session_repository->_find_by_order_id_from_session_table($order_id);

        // Assert
        $this->assertInstanceOf(Session::class, $session_entity);
    }





    /** @test */
    public function _insert_into_session_table__check_if_you_can_insert_a_session_object_to_database()
    {
        // Arrange
        // Hent seneste order_id fra fra
        $array_of_sessions = $this->session_repository->_get_all_from_session_table();

        // Soter sa første element i arrayet er højeste order_id
        usort($array_of_sessions, function ($a, $b) {
            return $b->order_id <=> $a->order_id;
        });

        // Det nye order_id er det højeste order_id + 1
        $order_id = $array_of_sessions[0]->order_id + 1;

        // Act


        // Lav entity som repræsentere session tabellen
        $session_entity = new Session(
            $session_pk = null,
            $order_id   = $order_id,
            $order_status_payment_accepted                  = true,
            $order_status_payment_currency                  = 'DKK',
            $order_status_payment_amount                    = 100,
            $order_status_payment_quickpay_id               = 12345,
            $order_status_payment_details_satisfied         = true,
            $order_status_email_confirmation_sent           = true,
            $order_status_email_invoice_sent_to_customer    = true,
            $customer_fullname                              = 'Victor Reipur',
            $customer_details_satisfied_for_payment         = false,
            $customer_address_street                        = 'Vinkelvej 12D',
            $customer_address_postal_code                   = 2800,
            $customer_address_city                          = 'Århus C',
            $customer_contact_phone                         = 26129604,
            $customer_contact_email                         = 'victor.reipur@gmail.com',
            $customer_company_cvr_number                    = null,
            $customer_company_name                          = null,
            $shipment_tracking_number                       = 123456,
            $shipment_order_collected                       = true,
            $shipment_details_satisfied                     = true,
            $shipment_address_street_name                   = 'Århusvej',
            $shipment_address_street_number                 = '12',
            $shipment_address_postal_code                   = 8210,
            $shipment_address_city                          = 'Århus'
        );


        $success = $this->session_repository->_insert_into_session_table($session_entity);

        $this->assertTrue($success , true);

    }




    /** @test */
    public function _update_session_table__check_if_you_can_update_a_session_object_to_database()
    {
        // Arrange
        // Hent seneste order_id fra fra
        $array_of_sessions = $this->session_repository->_get_all_from_session_table();

        // Soter sa første element i arrayet er højeste order_id
        usort($array_of_sessions, function ($a, $b) {
            return $a->order_id <=> $b->order_id;
        });

        // Det nye order_id er det højeste order_id + 1

        // updater det første element i arrayet
        $order_id = $array_of_sessions[0]->order_id;


        $session_entity = $array_of_sessions[0];
        $session_entity->order_status_payment_amount += 400;


        // Act
        $success = $this->session_repository->_update_session_table($order_id, $session_entity);

        // Assert
        $this->assertTrue($success , true);
    }


    /** @test */
    public function _delete_session_table__check_if_you_can_delete_a_session_object_in_database()
    {
        // Arrange
        // Hent seneste order_id fra fra
        $array_of_sessions = $this->session_repository->_get_all_from_session_table();

        // Soter sa første element i arrayet er højeste order_id
        usort($array_of_sessions, function ($a, $b) {
            return $a->order_id <=> $b->order_id;
        });

        // Delete det første element i databasen

        // updater det første element i arrayet
        $order_id = $array_of_sessions[0]->order_id;

        // Assert
        $this->assertTrue($this->session_repository->_delete_session_table($order_id) , true);
    }
}
