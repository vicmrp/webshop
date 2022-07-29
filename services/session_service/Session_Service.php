<?php

namespace vezit\services\session_service;

use Session_Order_Update_Request;
use vezit\api\dawa_api\Dawa_API;
use vezit\api\postnord_api\Postnord_API;
use vezit\models\session\Session;
use vezit\dto\Session_Response;
use vezit\dto\Session_Delete_Response;
use vezit\dto\Session_Order_Update_Requests;
use vezit\dto\Session_Update_Customer_Request;
use vezit\entities\Product;
use vezit\repositories\session_repository\Session_Repository;
use vezit\entities\session\Session_Entity;
use vezit\models\session\order\item\Item;
use vezit\repositories\product_repository\Product_Repository;
use vezit\services\postnord_service\Postnord_Service;
use vezit\services\session_variables_service\Session_Variables_Service;
use vezit\models\session\shipment\Shipment;
use vezit\services\quickpay_service\Quickpay_Service;
use vezit\dto\payment_link_response\Payment_Link_Response;
use vezit\dto\Postnord_Service_Point_Response;
use vezit\dto\update_customer_request\Update_Customer_Request;
use vezit\models\session\customer\Customer;
use vezit\models\session\customer\address\Address;
use vezit\models\session\shipment\address\Address as Shipment_Address;
use vezit\models\session\customer\company\Company;
use vezit\models\session\customer\contact\Contact;
use vezit\models\session\order\Order;
use vezit\models\session\order\status\payment\Payment;
use vezit\api\quickpay_api\Quickpay_API;

require __DIR__ . '/../../global-requirements.php';

class Session_Service
{
    private static $_times_instantiated = 0;
    private static $_instance = null;




    public static function get_instance(
        Session_Repository              $session_repository         = null,
        Product_Repository              $product_repository         = null,
        Dawa_API                        $dawa_api                   = null,
        Postnord_Service                $postnord_service           = null,
        Quickpay_Service                $quickpay_service           = null,
        Session_Variables_Service       $session_variables_service  = null,
    ) : Session_Service
    {
        return (null === self::$_instance) ? new Session_Service(

            null === $session_repository         ? Session_Repository::get_instance()        : $session_repository
            ,null === $product_repository        ? Product_Repository::get_instance()        : $product_repository
            ,null === $dawa_api                  ? Dawa_API::get_instance()                  : $dawa_api
            ,null === $postnord_service          ? Postnord_Service::get_instance()          : $postnord_service
            ,null === $quickpay_service          ? Quickpay_Service::get_instance()          : $quickpay_service
            ,null === $session_variables_service ? Session_Variables_Service::get_instance() : $session_variables_service

        ) : self::$_instance;
    }

    public static function destroy_instance() : void {
        self::$_instance = null;
    }

    private function __construct(
        private Session_Repository          $_session_repository
        ,private Product_Repository         $_product_repository
        ,private Dawa_API                   $_dawa_api
        ,private Postnord_Service           $_postnord_service
        ,private Quickpay_Service           $_quickpay_service
        ,private Session_Variables_Service  $_session_variables_service
    ) {
        self::$_instance = $this;
        self::$_times_instantiated++;
    }





    public function get_session() : Session_Response
    {
        return $this->_session_variables_service->get_session_response();
    }








    public function get_payment_link() : Payment_Link_Response
    {
        // Return a payment link if...
        $session_response = $this->_session_variables_service->get_session_response();

        $payment_link_response = $this->_quickpay_service->get_payment_link($session_response);

        $this->_session_variables_service->update_session_response($session_response);

        return $payment_link_response;

    }




    public function update_customer(Update_Customer_Request $update_customer_request): Session_Response {




        $session_response = $this->_session_variables_service->get_session_response();

        $session_response->session->customer = new Customer(
            $fullname                           = $update_customer_request->fullname,
            $details_satisfied_for_shipment     = $this->_customer_details_is_satisfied($update_customer_request),

            // In order to fill in customer details, there needs to be something in the basket
            $has_at_least_one_item_in_basket    = $this->_has_at_least_one_item_in_basket($session_response->session->order),

            $address = new Address(
                $street        = $update_customer_request->address->street,
                $postal_code   = $update_customer_request->address->postal_code,
                $city          = $update_customer_request->address->city
            ),
            $contact = new Contact(
                $phone = $update_customer_request->contact->phone,
                $email = $update_customer_request->contact->email
            ),
            $company = new Company(
                $cvr_number    = $update_customer_request->company->cvr_number,
                $company_name  = $update_customer_request->company->company_name
            )
        );



        $this->_session_variables_service->update_session_response($session_response);
        return $this->_session_variables_service->get_session_response();
    }





    private function _has_at_least_one_item_in_basket(Order $order) : bool {
        // if array is empty
        if (count($order->get_items()) === 0) {
            return false;
        }
        return true;
    }






    public function update_order(Session_Order_Update_Requests $session_order_update_requests): Session_Response
    {

        $session_response = $this->_session_variables_service->get_session_response();
        $items = [];
        $amount = 0;
        foreach ($session_order_update_requests->get() as $session_order_update_request) {

            $product = $this->_product_repository->get_by_pk($session_order_update_request->product_pk);

            if ($product->quantity < $session_order_update_request->quantity)
                throw new \Exception("You are trying too add more products than is in stock", 1);

            if (0 >= $session_order_update_request->quantity)
                continue;

            $item = new Item(
                $product_pk_fk  = $product->product_pk,
                $name           = $product->name,
                $price          = $product->price,
                $quantity       = $session_order_update_request->quantity
            );
            $amount += $product->price * $item->quantity;
            array_push($items, $item);
        }

        $session_response->session->order->set_items($items);
        $session_response->session->order->status->payment->amount = $amount;
        $this->_order_details_is_satisfied($session_response);
        $session_response->session->customer->has_at_least_one_item_in_basket = $this->_has_at_least_one_item_in_basket($session_response->session->order);

        $this->_session_variables_service->update_session_response($session_response);
        return $this->_session_variables_service->get_session_response();
    }
















    public function update_shipment(int $service_point_id): Session_Response
    {
        $session_response = $this->_session_variables_service->get_session_response();


        # You need to fill in customer details before you can get postal service details
        if (!$session_response->session->customer->details_satisfied_for_shipment) {
            return $session_response;
        }



        $postnord_service_point_response = $this->_postnord_service->get_by_id($service_point_id);

        $session_response->session->shipment = new Shipment(
            $tracking_number                = null,
            $order_collected                = false,
            $details_satisfied_for_payment  = $this->_shipment_details_is_satisfied($postnord_service_point_response), # :D
            $service_point_id               = $postnord_service_point_response->service_point_id,
            $name                           = $postnord_service_point_response->name,
            $address                        = new Shipment_Address(
                $street_name      = $postnord_service_point_response->street_name,
                $street_number    = $postnord_service_point_response->street_number,
                $postal_code      = $postnord_service_point_response->postal_code,
                $city             = $postnord_service_point_response->city
            )
        );

        $this->_session_variables_service->update_session_response($session_response);
        return $this->_session_variables_service->get_session_response();

    }



















    public function unset_session(): Session_Delete_Response
    {
        return $this->_session_variables_service->unset_session_response();
    }















    private function _customer_details_is_satisfied(Update_Customer_Request $update_customer_request): bool
    {

        if (null === $update_customer_request->fullname) return false;
        if (null === $update_customer_request->address->street) return false;
        if (null === $update_customer_request->address->postal_code) return false;
        if (null === $update_customer_request->address->city) return false;
        if (null === $update_customer_request->contact->phone) return false;
        if (null === $update_customer_request->contact->email) return false;

        return true;

    }




















    private function _order_details_is_satisfied(Session_Response &$session_response): void
    {
        if (null === $session_response->session->order->status->payment->amount) {
            $session_response->session->order->status->payment->details_satisfied_for_payment = false;
            return;
        }
        if (0 >= $session_response->session->order->status->payment->amount) {
            $session_response->session->order->status->payment->details_satisfied_for_payment = false;
            return;
        }

        $session_response->session->order->status->payment->details_satisfied_for_payment = true;
    }






















    private function _shipment_details_is_satisfied(Postnord_Service_Point_Response $postnord_service_point_response): bool
    {

        if (null === $postnord_service_point_response->service_point_id)            return false;
        if (null === $postnord_service_point_response->name)                        return false;
        if (null === $postnord_service_point_response->street_name)                 return false;
        if (null === $postnord_service_point_response->street_number)               return false;
        if (null === $postnord_service_point_response->postal_code)                 return false;
        if (null === $postnord_service_point_response->city)                        return false;

        return true;
    }






    // TODO: set_customer

    // TODO: get_service_points

    // TODO: set_shipment

    // TODO: create_payment

    // TODO: insert to database


    // public function set_customer(Customer $customer) : Get_Session_Response
    // {
    //     $session_response = $this->get_session();

    //     $customer = $session_response->session->customer;

    //     $customer->fullname = 'Victor Reipur';

    //     $_SESSION["session_response"] = serialize($session_response);

    //     return $this->get_session();
    // }




}
