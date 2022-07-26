<?php

namespace vezit\services\quickpay_service;

use vezit\api\quickpay_api\Quickpay_API;


require __DIR__ . '/../../global-requirements.php';

class Quickpay_Service
{
    private static $_times_instantiated = 0;
    private static $_instance = null;






    public static function get_instance(Quickpay_API $quickpay_api = null)
    {
        // Laver en instance hvis den ikke findes.
        // Laver en ny instance hvis get_instance bliver kaldet med parametre.
        return (null === self::$_instance || null !== $quickpay_api) ? new Quickpay_Service(

            (null === $quickpay_api) ? Quickpay_API::get_instance() : $quickpay_api

            ) : self::$_instance;
    }



    public function __construct(
        private Quickpay_API $_quickpay_api
    ) {
        self::$_times_instantiated++;
    }


    //Try to make it work so that you can retrive a payment link.
    public function create_a_new_payment(string $order_id): object
    {
        return $this->_quickpay_api->call_create_a_new_payment($order_id);
    }






    // return payment link if requirements are meet. Otherwise return reason for why it is not meet.
    public function get_payment_link()
    {
        // Is all payment details satistfied?

        // Check in the session variable

        //


        // $payment_link = $this->_quickpay_api->call_get_payment_link();

    }
}
