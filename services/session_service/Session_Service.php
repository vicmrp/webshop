<?php

namespace vezit\services\session_service;

use vezit\api\dawa_api\Dawa_API;
use vezit\dto\get_payment_link_response\Get_Payment_Link_Response;



use vezit\dto\get_session_response\Get_Session_Response;

use vezit\entities\Session;
use vezit\entities\Sessions;
use vezit\entities\Session_Order_Items;
use vezit\entities\Session_Order_Item;

use vezit\models\session\customer\address\Address;
use vezit\models\session\customer\company\Company;
use vezit\models\session\customer\contact\Contact;
use vezit\models\session\customer\Customer;
use vezit\models\session\order\item\Item;
use vezit\models\session\order\Order;
use vezit\models\session\shipment\address\Address as Shipment_Address;
use vezit\models\session\shipment\Shipment;
use vezit\repositories\product_repository\Product_Repository;
use vezit\repositories\order_repository\Order_Repository;
use vezit\services\postnord_service\Postnord_Service;
use vezit\services\quickpay_service\Quickpay_Service;
use vezit\services\session_variables_service\Session_Variables_Service;
use vezit\classes\error\Error;
use vezit\dto\put_update_order_items_request\Put_Update_Order_Items_Request;
use vezit\dto\put_update_order_items_response\Put_Update_Order_Items_Response;

use vezit\dto\put_update_customer_request\Put_Update_Customer_Request;
use vezit\dto\put_update_customer_response\Put_Update_Customer_Response;


use vezit\dto\get_service_points_response\Service_Point;

use vezit\dto\put_update_shipment_request\Put_Update_Shipment_Request;
use vezit\dto\put_update_shipment_response\Put_Update_Shipment_Response;

require __DIR__ . '/../../global-requirements.php';

class Session_Service 
{
    private static $_times_instantiated = 0;
    private static $_instance = null;



    // ------------ SINGLETON PATTERN -------------- //
    public static function get_instance(
        Order_Repository          $order_repository         = null,
        Quickpay_Service          $quickpay_service         = null,
        Session_Variables_Service $session_variables_service= null
    ): Session_Service {
        try {
            if (null === self::$_instance) {
                $order_repo = $order_repository ?? Order_Repository::get_instance();
                $quickpay = $quickpay_service ?? Quickpay_Service::get_instance();
                $session_vars = $session_variables_service ?? Session_Variables_Service::get_instance();
                self::$_instance = new Session_Service($order_repo, $quickpay, $session_vars);
            }
            return self::$_instance;
        } catch (\Exception $e) {
            // Log the error message in the apache error log
            Error::log($e->getMessage() . ' ' . $e->getTraceAsString());
        
            // Check if the server is in sandbox mode
            global $g_sandbox_mode_enabled;
            if ($g_sandbox_mode_enabled) {
                // If the server is in sandbox mode, display the error message and callstack to the client
                // This is useful for debugging
                $errorJson = Error::toJson($e->getCode(), $e->getMessage(), [
                    "callstack" => $e->getTraceAsString(),
                    "file" => $e->getFile()
                ]);
                echo $errorJson;
                exit;
            } else {
                // If the server is not in sandbox mode, display a generic error message to the client
                // This is to prevent sensitive information from being displayed to the client
                echo 'Internal server error';
                exit;
            }
        }
    }

    public static function destroy_instance(): void
    {
        self::$_instance = null;
    }

    private function __construct(
        private Order_Repository           $_session_repository,
        private Quickpay_Service           $_quickpay_service,
        private Session_Variables_Service  $_session_variables_service
    ) {
        try {
            self::$_instance = $this;
            self::$_times_instantiated++;
        } catch (\Exception $e) {
            // Log the error message in the apache error log
            Error::log($e->getMessage() . ' ' . $e->getTraceAsString());
        
            // Check if the server is in sandbox mode
            global $g_sandbox_mode_enabled;
            if ($g_sandbox_mode_enabled) {
                // If the server is in sandbox mode, display the error message and callstack to the client
                // This is useful for debugging
                $errorJson = Error::toJson($e->getCode(), $e->getMessage(), [
                    "callstack" => $e->getTraceAsString(),
                    "file" => $e->getFile()
                ]);
                echo $errorJson;
                exit;
            } else {
                // If the server is not in sandbox mode, display a generic error message to the client
                // This is to prevent sensitive information from being displayed to the client
                echo 'Internal server error';
                exit;
            }
        }
    }
    // ------------ SINGLETON PATTERN -------------- //
















































    public function get_session($order_id = null): Get_Session_Response
    {

        $get_session_response = $this->_session_variables_service->get_get_session_response($order_id);
        return $get_session_response;
    }













































    public function get_payment_link(): Get_Payment_Link_Response
    {
        // Return a payment link if...
        $get_session_response = $this->_session_variables_service->get_get_session_response();

        $get_payment_link_response = $this->_quickpay_service->get_payment_link($get_session_response);

        // if payment link is not null then insert session to database
        if (null !== $get_payment_link_response->payment_link) {

            // Insert session to database
            $session_entity = new Session(
                $session_id = null,
                $order_id  = $get_session_response->session->order->id,
                $datetime_created                               = null,
                $datetime_last_modified                         = null,
                $order_status_payment_accepted                  = $get_session_response->session->order->status->payment->accepted,
                $order_status_payment_currency                  = $get_session_response->session->order->status->payment->currency,
                $order_status_payment_amount                    = $get_session_response->session->order->status->payment->amount,
                $order_status_payment_quickpay_id               = $get_session_response->session->order->status->payment->quickpay_id,
                $order_status_email_invoice_sent_to_customer    = $get_session_response->session->order->status->email->invoice_sent_to_customer,
                $customer_fullname                              = $get_session_response->session->customer->fullname,
                $customer_tos_and_tac_has_been_accepted         = $get_session_response->session->customer->tos_and_tac_has_been_accepted,
                $customer_contact_email                         = $get_session_response->session->customer->contact->email
            );

            $this->_session_repository->insert($session_entity);
        }

        $this->_session_variables_service->update_put_session_response($get_session_response);
        return $get_payment_link_response;
    }


































    public function update_customer(Put_Update_Customer_Request $update_customer_request): Put_Update_Customer_Response
    {


        $session_response = $this->_session_variables_service->get_get_session_response();

        $session_response->session->customer = new Customer(
            $fullname                           = $update_customer_request->fullname,
            $tos_and_tac_has_been_accepted      = $update_customer_request->tos_and_tac_has_been_accepted,
            $customer_details_is_satisfied      = $this->_customer_details_is_satisfied($update_customer_request),

            // In order to fill in customer details, there needs to be something in the basket

            $contact = new Contact(
                $email = $update_customer_request->contact->email
            )

        );

        // if customer details satisfied




        $this->_session_variables_service->update_put_session_response($session_response);

        $update_customer_response = new Put_Update_Customer_Response($this->_session_variables_service->get_get_session_response()->session->customer);

        return $update_customer_response;
    }




















    private function _customer_details_is_satisfied(Put_Update_Customer_Request $put_update_customer_request): bool
    {


        // ------- fullname ------ //
        // false if null
        if (null === $put_update_customer_request->fullname) return false;

        // false if empty
        if (0 === strlen($put_update_customer_request->fullname)) return false;

        // false if more than 100 characters
        if (100 < strlen($put_update_customer_request->fullname)) return false;
        // ------- fullname ------ //



        // ------- terms and conditions and terms of service ------ //
        // false if null
        if (null === $put_update_customer_request->tos_and_tac_has_been_accepted) return false;

        // false if false
        if (false === $put_update_customer_request->tos_and_tac_has_been_accepted) return false;
        // ------- terms and conditions and terms of service ------ //


        //$put_update_customer_request->contact->email does not contain @

        // ------- email ------ //
        // false if fidld is empty
        if (null === $put_update_customer_request->contact->email) return false;

        // false if @ is not found
        if (false === strpos($put_update_customer_request->contact->email, '@')) return false;

        // false if @ is the first character
        if (0 === strpos($put_update_customer_request->contact->email, '@')) return false;

        // false if @ is the last character
        if (strlen($put_update_customer_request->contact->email) === strpos($put_update_customer_request->contact->email, '@') + 1) return false;

        // false if @ is found more than once
        if (1 < substr_count($put_update_customer_request->contact->email, '@')) return false;

        // false if . is not found
        if (false === strpos($put_update_customer_request->contact->email, '.')) return false;

        // false if . is the first character
        if (0 === strpos($put_update_customer_request->contact->email, '.')) return false;

        // false if . is the last character
        if (strlen($put_update_customer_request->contact->email) === strpos($put_update_customer_request->contact->email, '.') + 1) return false;


        // ------- email ------ //



        // details are satisfied
        return true;
    }
}
