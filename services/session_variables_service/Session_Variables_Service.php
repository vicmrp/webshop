<?php

namespace vezit\services\session_variables_service;

use vezit\classes\login\Login;
use vezit\dto\Login_Response;
use vezit\dto\Session_Response;
use vezit\models\session\Session;
use vezit\models\session\customer\Customer;
use vezit\models\session\order\Order;
use vezit\models\session\shipment\Shipment;
use vezit\models\session\order\status\Status;
use vezit\models\session\order\item\Item;
use vezit\models\session\order\status\payment\Payment;
use vezit\models\session\order\status\email\Email;
use vezit\dto\Session_Delete_Response;
use vezit\dto\Login_Request;

class Session_Variables_Service
{
    private static $_times_instantiated = 0;
    private static $_instance = null;




    public static function get_instance()
    {
        return null === self::$_instance ? new Session_Variables_Service : self::$_instance;
    }



    public static function destroy_instance(): void
    {
        self::$_instance = null;
    }



    private function __construct()
    {
        self::$_instance = $this;
        self::$_times_instantiated++;
    }



    private function _init_session_response(): Session_Response
    {
        return new Session_Response(
            new Session(
                new Customer,
                new Order(
                    $id = g_generate_random_string(20),
                    $items = [],
                    $status = new Status(
                        new Payment(
                            $accepted                           = false,
                            $currency                           = "DKK",
                            $amount                             = 0,
                            $quickpay_id                        = null,
                            $details_satisfied_for_payment      = false
                        ),
                        new Email(
                            $confirmation_sent          = false,
                            $invoice_sent_to_customer   = false
                        )
                    )
                ),
                new Shipment
            )
        );
    }


    // --------- session_response --------- //
    public function get_session_response(): Session_Response
    {
        return !isset($_SESSION["session_response"])
            ? unserialize($_SESSION["session_response"] = serialize($this->_init_session_response()))
            : unserialize($_SESSION["session_response"]);
    }


    public function update_session_response(Session_Response $session_response) : void
    {
        $_SESSION["session_response"] = !isset($_SESSION["session_response"])
            ?  throw new \Exception('$_SESSION["session_response"] does not exist', 1)
            :  serialize($session_response);
    }


    public function unset_session_response() : Session_Delete_Response {

        if ( !isset($_SESSION["session_response"]) )
            return new Session_Delete_Response(
                $session_has_been_unset = false
                ,$note                  = 'session_response variable did not exist'
            );

        unset($_SESSION["session_response"]);

        return new Session_Delete_Response(
            $session_has_been_unset  = true
            ,$note                   = 'session_response variable has been deleted'
        );
    }
    // --------- session_response --------- //



    // --------- login_response --------- //
    public function get_login_response() : Login_Response
    {
        return new Login_Response;
    }


    public function update_login_response(Login_Request $login_request) : Login_Response
    {
        return new Login_Response;
    }
    // --------- login_response --------- //



}
