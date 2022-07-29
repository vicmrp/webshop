<?php

namespace vezit\services\quickpay_service;

use vezit\api\quickpay_api\Quickpay_API;
use vezit\dto\payment_link_response\Payment_Link_Response;
use vezit\dto\Session_Response;

require __DIR__ . '/../../global-requirements.php';

class Quickpay_Service
{
    private static $_times_instantiated = 0;
    private static $_instance = null;






    public static function get_instance(Quickpay_API $quickpay_api = null)
    {
        // Laver en instance hvis den ikke findes.
        // Laver en ny instance hvis get_instance bliver kaldet med parametre.
        return (null === self::$_instance) ? new Quickpay_Service(

            (null === $quickpay_api) ? Quickpay_API::get_instance() : $quickpay_api

            ) : self::$_instance;
    }

    public static function destroy_instance() : void {
        self::$_instance = null;
    }

    private function __construct(
        private Quickpay_API $_quickpay_api
    ) {
        self::$_instance = $this;
        self::$_times_instantiated++;
    }


    //Try to make it work so that you can retrive a payment link.
    private function _create_a_new_payment(&$session_response): void
    {

        $payment = $this->_quickpay_api->call_create_a_new_payment($session_response->session->order->id);

        $session_response->session->order->status->payment->quickpay_id = $payment->id;


    }






    // return payment link if requirements are meet. Otherwise return reason for why it is not meet.
    public function get_payment_link(Session_Response &$session_response) : Payment_Link_Response
    {



        if (!$session_response->session->customer->details_satisfied_for_shipment
        ||  !$session_response->session->shipment->details_satisfied_for_payment
        ||  !$session_response->session->order->status->payment->details_satisfied_for_payment) {
            return new Payment_Link_Response(
                $url =  null,
                $note = 'details are not satisfied for payment'
            );
        }

        // Return if payment has already been created
        if (null !== $session_response->session->order->status->payment->quickpay_id) {
            return new Payment_Link_Response(
                $url  = $this->_quickpay_api->call_get_payment_link(
                    $id      = $session_response->session->order->status->payment->quickpay_id,
                    $amount  = $session_response->session->order->status->payment->amount
                )->url
                ,$note = 'payment already exist therefore you get a payment link based on that payment'
            );
        }


        // Create a new payment
        $this->_create_a_new_payment($session_response);




        return new Payment_Link_Response(
            $url  = $this->_quickpay_api->call_get_payment_link(
                $id      = $session_response->session->order->status->payment->quickpay_id,
                $amount  = $session_response->session->order->status->payment->amount
            )->url
            ,$note = 'New payment has been created'
        );




    }
}
