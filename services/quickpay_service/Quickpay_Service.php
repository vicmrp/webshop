<?php

namespace vezit\services\quickpay_service;

use vezit\api\quickpay_api\Quickpay_API;
use vezit\dto\get_payment_link_response\Get_Payment_Link_Response;
use vezit\dto\get_session_response\Get_Session_Response;
use vezit\services\session_variables_service\Session_Variables_Service;
use vezit\services\session_service\Session_Service;
use vezit\dto\put_update_customer_request\Put_Update_Customer_Request;

require __DIR__ . '/../../global-requirements.php';

class Quickpay_Service
{
    private static $_times_instantiated = 0;
    private static $_instance = null;






    public static function get_instance(
        Quickpay_API                    $quickpay_api               = null,
        Session_Variables_Service       $session_variables_service  = null
        )
    {
        // Laver en instance hvis den ikke findes.
        // Laver en ny instance hvis get_instance bliver kaldet med parametre.
        return (null === self::$_instance) ? new Quickpay_Service(

            (null === $quickpay_api)                ? Quickpay_API::get_instance()              : $quickpay_api
            ,null === $session_variables_service    ? Session_Variables_Service::get_instance() : $session_variables_service

            ) : self::$_instance;
    }

    public static function destroy_instance() : void {
        self::$_instance = null;
    }

    private function __construct(
        private Quickpay_API $_quickpay_api
        ,private Session_Variables_Service  $_session_variables_service
    ) {
        self::$_instance = $this;
        self::$_times_instantiated++;
    }
































    public function get_payment(int $id) {
        return $this->_quickpay_api->call_get_payment($id);
    }




















    //Try to make it work so that you can retrive a payment link.
    private function _create_a_new_payment(&$session_response): void
    {

        $payment = $this->_quickpay_api->call_create_a_new_payment($session_response->session->order->id);

        $session_response->session->order->status->payment->quickpay_id = $payment->id;



    }






    // return payment link if requirements are meet. Otherwise return reason for why it is not meet.
    public function get_payment_link(Get_Session_Response &$session_response) : Get_Payment_Link_Response
    {
        $payment_link_response = $this->_session_variables_service->get_payment_link_response();

        $payment_link_exist_already = (null !== $payment_link_response->payment_link) ? true : false;



        if ($payment_link_exist_already) {
            $payment_link_response->note = "Payment link comes from stored property";

            // Updating the note, not the link
            $this->_session_variables_service->update_payment_link_response($payment_link_response);

            return $this->_session_variables_service->get_payment_link_response();
        }

        $details_are_not_satisfied_for_payment = (false  === $session_response->session->customer->customer_details_is_satisfied ) ? true : false ;


        if ($details_are_not_satisfied_for_payment) {
            return new Get_Payment_Link_Response(
                $url =  null,
                $note = "details are not satisfied for payment The session with the payment id: {$session_response->session->order->id} has not been stored."
            );
        }



        $quickpay_payment_has_already_been_created = (null !== $session_response->session->order->status->payment->quickpay_id) ? true : false;


        // Return if payment has already been created
        if ($quickpay_payment_has_already_been_created) {

            $payment_link_response->payment_link = $this->_quickpay_api->call_get_payment_link(
                $id      = $session_response->session->order->status->payment->quickpay_id,
                $order_id  = $session_response->session->order->id,
                $amount  = $session_response->session->order->status->payment->amount
            )->url;

            $payment_link_response->note = "payment already exist therefore you get a payment link based on that payment. The session has been stored with the payment id: {$session_response->session->order->id}";

            // Update payment link response then return it
            $this->_session_variables_service->update_payment_link_response($payment_link_response);
            return $this->_session_variables_service->get_payment_link_response();

        }


        // Create a new payment
        $this->_create_a_new_payment($session_response);


        $payment_link_response->payment_link = $this->_quickpay_api->call_get_payment_link(
            $id      = $session_response->session->order->status->payment->quickpay_id,
            $order_id  = $session_response->session->order->id,
            $amount  = 14900
        )->url;

        $payment_link_response->note = "New payment has been created. The session has been stored with the payment id: {$session_response->session->order->id}";



        $this->_session_variables_service->update_payment_link_response($payment_link_response);
        return $this->_session_variables_service->get_payment_link_response();



    }















// capture payment
    public function capture_payment(int $id, int $amount) : void
    {
        $this->_quickpay_api->call_capture_payment($id, $amount);
    }





























}
