<?php

namespace vezit\api\quickpay_api;

class Quickpay_API
{
    private static $_times_instantiated = 0;
    private static $_instance = null;

    public static function get_instance()
    {
        return (null === self::$_instance) ? new Quickpay_API : self::$_instance;
    }

    private function __construct()
    {self::$_times_instantiated++;}


    // Create a new payment and add the payment id to the session.
    // 1. Create a new payment
    // https://learn.quickpay.net/tech-talk/guides/payments/#create-a-new-payment
    // -------------------------------------------------------------------------- //
    public function call_create_a_new_payment(string $order_id) : object
    {
        global $g_quickpay_apikey;
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.quickpay.net/payments',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('currency' => 'dkk', 'order_id' => $order_id),
            CURLOPT_HTTPHEADER => array(
                'Accept-Version: v10',
                "Authorization: Basic $g_quickpay_apikey="
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return (object)json_decode($response);
    }
    // -------------------------------------------------------------------------- //







    public function call_get_payment(int $id): object
    {
        global $g_quickpay_apikey;
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.quickpay.net/payments/$id/",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => array(),
            CURLOPT_HTTPHEADER => array(
                'Accept-Version: v10',
                "Authorization: Basic $g_quickpay_apikey="
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return (object)json_decode($response);
    }





    public function call_get_payment_link(int $id, string $order_id, int $amount): object
    {
        global $g_quickpay_apikey;
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.quickpay.net/payments/$id/link",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_POSTFIELDS => array(
                'amount' => $amount
                ,'continue_url' => "https://vezit.net/vezit-service-callbacks/quickpay.php?order_id=$order_id"
                ,'cancel_url' => "https://vezit.net/callback?order_id=$order_id"
            ),
            CURLOPT_HTTPHEADER => array(
                'Accept-Version: v10',
                "Authorization: Basic $g_quickpay_apikey=",
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response);
    }






    public function call_cancel_payment(string $id): object
    {

        global $g_quickpay_apikey;
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.quickpay.net/payments/$id/cancel",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array(),
            CURLOPT_HTTPHEADER => array(
                'Accept-Version: v10',
                "Authorization: Basic $g_quickpay_apikey="
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return (object)json_decode($response);
    }

















    public function call_capture_payment(string $id, int $amount): object
    {
        global $g_quickpay_apikey;
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.quickpay.net/payments/$id/capture",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array('amount' => $amount),
            CURLOPT_HTTPHEADER => array(
                'Accept-Version: v10',
                "Authorization: Basic $g_quickpay_apikey="
            ),
        ));


        $response = curl_exec($curl);

        curl_close($curl);

        return (object)json_decode($response);

    }













}
