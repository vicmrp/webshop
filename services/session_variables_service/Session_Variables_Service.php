<?php



namespace vezit\services\session_variables_service;


use vezit\dto\post_login_response\Post_Login_Response;
use vezit\dto\delete_session_variables_response\Delete_Session_Variables_Response;
use vezit\dto\get_session_response\Get_Session_Response;
use vezit\models\session\Session;
use vezit\models\session\customer\Customer;
use vezit\models\session\customer\contact\Contact;
use vezit\models\session\order\Order;
use vezit\models\session\shipment\Shipment;
use vezit\models\session\order\status\Status;
use vezit\models\session\order\status\payment\Payment;
use vezit\models\session\order\status\email\Email;
use vezit\dto\get_payment_link_response\Get_Payment_Link_Response;
use vezit\repositories\session_repository\Session_Repository;

require __DIR__ . '/../../global-requirements.php';

// This is where DTOs are bourne and where they are updated
// If a value inside the DTO is null, then it has never been set. All vaules in a dto class is always set to null when it is created.

class Session_Variables_Service
{
    private static $_times_instantiated = 0;
    private static $_times_destroyed = 0;
    private static $_instance = null;




    public static function get_instance(Session_Repository $session_repository = null,)
    {
        return null === self::$_instance ? new Session_Variables_Service(
            null === $session_repository ? Session_Repository::get_instance() : $session_repository,
        ) : self::$_instance;
    }



    public static function destroy_instance(): void
    {
        if (null !== self::$_instance) {
            self::$_times_destroyed++;
            self::$_instance = null;
        }
    }



    private function __construct(private Session_Repository $_session_repository)
    {
        self::$_instance = $this;
        self::$_times_instantiated++;
    }
























    // --------- login_response --------- //
    public function get_post_login_response(): Post_Login_Response
    {
        $POST_LOGIN_RESPONSE = 'post_login_response';

        $login_response_is_not_set = !isset($_SESSION[$POST_LOGIN_RESPONSE]);

        if ($login_response_is_not_set) {
            $_SESSION[$POST_LOGIN_RESPONSE] = serialize($this->_init_login_response());
        }

        return unserialize($_SESSION[$POST_LOGIN_RESPONSE]);
    }


    private function _init_login_response(): Post_Login_Response
    {
        return new Post_Login_Response(
            $email                      = "",
            $access_granted             = false,
            $message                    = "first time initiated - user was not logged in."
        );
    }


    public function update_post_login_response(Post_Login_Response $post_login_response): void
    {
        $POST_LOGIN_RESPONSE = 'post_login_response';

        $post_login_response_is_not_set = !isset($_SESSION[$POST_LOGIN_RESPONSE]) ? true : false;

        if ($post_login_response_is_not_set) {
            throw new \Exception("\$_SESSION[\"$POST_LOGIN_RESPONSE\"] does not exist", 1);
        }

        // Replacing value in this variable
        $_SESSION[$POST_LOGIN_RESPONSE] = serialize($post_login_response);
    }
    // --------- login_response --------- //
















    // --------- payment_link_response --------- //

    public function get_payment_link_response(): Get_Payment_Link_Response
    {

        $get_payment_link_response_is_not_set = !isset($_SESSION["get_payment_link_response"]) ? true : false;

        if ($get_payment_link_response_is_not_set) {
            // initiating var because it does not exist
            $_SESSION["get_payment_link_response"] = serialize($this->_init_get_payment_link_response());
        }

        return unserialize($_SESSION["get_payment_link_response"]);
    }


    private function _init_get_payment_link_response(): Get_Payment_Link_Response
    {
        return new Get_Payment_Link_Response(
            $url  = null,
            $note = "first time initiated"
        );
    }


    public function update_payment_link_response(Get_Payment_Link_Response $get_payment_link_response): void
    {

        $get_payment_link_response_is_not_set = !isset($_SESSION["get_payment_link_response"]) ? true : false;

        if ($get_payment_link_response_is_not_set) {
            throw new \Exception('$_SESSION["payment_link_response"] does not exist', 1);
        }

        $_SESSION["get_payment_link_response"] = serialize($get_payment_link_response);
    }
    // --------- payment_link_response --------- //






























    // --------- session_response --------- //
    public function get_get_session_response($order_id = null): Get_Session_Response
    {
        $SESSION_RESPONSE = 'get_session_response';



        $session_response_is_not_set = !isset($_SESSION[$SESSION_RESPONSE]);




        if ($session_response_is_not_set) {
            $_SESSION[$SESSION_RESPONSE] = serialize($this->_init_session_response());
        }




        // Get session from database if order_id is set
        if (null !== $order_id) {

            $session_entity = $this->_session_repository->get_by_order_id($order_id);

            $session_response = $this->get_get_session_response();

            $session_response->session->customer = new Customer(
                $fullname = $session_entity->customer_fullname,
                $tos_and_tac_has_been_accepted = $session_entity->customer_tos_and_tac_has_been_accepted,
                $customer_details_is_satisfied = true, // It cannot come from database if it is not satisfied
                new Contact(
                    $email = $session_entity->customer_contact_email
                )
                );


            $session_response->session->order->id = $session_entity->order_id;
            $session_response->session->order->set_items($session_entity->get_session_order_items());
            $session_response->session->order->status = new Status(
                new Payment(
                    $accepted                           = $session_entity->order_status_payment_accepted,
                    $currency                           = $session_entity->order_status_payment_currency,
                    $amount                             = $session_entity->order_status_payment_amount,
                    $quickpay_id                        = $session_entity->order_status_payment_quickpay_id,
                ),
                new Email(
                    $invoice_sent_to_customer   = $session_entity->order_status_email_invoice_sent_to_customer,
                )
                );

                $this->update_put_session_response($session_response);


        }





        return unserialize($_SESSION[$SESSION_RESPONSE]);
    }


    private function _init_session_response(): Get_Session_Response
    {

        global $g_order_id_length;

        return new Get_Session_Response(
            new Session(
                new Customer(
                    $fullname = "",
                    $tos_and_tac_has_been_accepted = false,
                    $customer_details_is_satisfied = false,
                    new Contact(
                        $email = ""
                    )
                ),
                new Order(
                    $id = g_generate_random_string($g_order_id_length),
                    $items = [],
                    $status = new Status(
                        new Payment(
                            $accepted                           = false,
                            $currency                           = "DKK",
                            $amount                             = 14900,
                            $quickpay_id                        = null
                        ),
                        new Email(
                            $invoice_sent_to_customer   = false
                        )
                    )
                )
            )
        );
    }



    public function update_put_session_response(Get_Session_Response $get_session_response): void
    {

        $get_session_response_is_not_set = !isset($_SESSION["get_session_response"]) ? true : false;

        if ($get_session_response_is_not_set) {
            throw new \Exception('$_SESSION["get_session_response"] does not exist', 1);
        }

        // Replacing value in this variable
        $_SESSION["get_session_response"] = serialize($get_session_response);
    }
    // --------- session_response --------- //




    // --------- delete_session_response --------- //
    public function delete_delete_all_session_variables(): Delete_Session_Variables_Response
    {

        $POST_LOGIN_RESPONSE = 'post_login_response';
        $GET_SESSION_RESPONSE = 'get_session_response';
        $GET_PAYMENT_LINK_RESPONSE = 'get_payment_link_response';



        if (!isset($POST_LOGIN_RESPONSE) && !isset($GET_SESSION_RESPONSE) && !isset($GET_PAYMENT_LINK_RESPONSE))
            return new Delete_Session_Variables_Response(
                $session_has_been_unset = false,
                $note                  = 'none of the session response variables did exist'
            );


        if (isset($POST_LOGIN_RESPONSE)) unset($_SESSION[$POST_LOGIN_RESPONSE]);
        if (isset($GET_SESSION_RESPONSE)) unset($_SESSION[$GET_SESSION_RESPONSE]);
        if (isset($GET_PAYMENT_LINK_RESPONSE)) unset($_SESSION[$GET_PAYMENT_LINK_RESPONSE]);

        return new Delete_Session_Variables_Response(
            $session_has_been_unset  = true,
            $note                   = 'all of the session response variables has been deleted'
        );
    }
    // --------- delete_session_response --------- //
}
