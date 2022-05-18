<?php

require __DIR__ . '/../../../../global-requirements.php';
header('Content-Type: application/json; charset=utf-8');

// TODO lav endpoint script Object Orienteret
// Under vezit\classes\api\controller\.--> session
//TODO lav en forbindelse ned til service laget og skab den nødvendige funktionalitet

use vezit\classes\api\endpoint\Endpoint;
use vezit\classes\api\quickpay\Quickpay;
use vezit\classes\error\Error;
use vezit\services\session_service\Session_Service;


function get_response(): object
{

    $endpoint = new Endpoint($controller_file_location = __FILE__);
    $endpoint->set_expected_get_parameters($required_get_parameters = array('functioncall'));

    $session_service = new Session_Service();
    switch ($endpoint->get_parameter->functioncall) {





        case 'get_session':
            return $session_service->get_session();







        case 'remove_order_item':
            $endpoint->set_expected_body_properties(array('product_id'));
            $product_id = (int)$endpoint->body->product_id;
            $session_response = $session_service->remove_order_item($product_id);
            return $session_response;







        case 'add_order_item':
            $endpoint->set_expected_body_properties(array('product_id', 'quantity'));
            $product_id = (int)$endpoint->body->product_id;
            $quantity = (int)$endpoint->body->quantity;
            $session_response = $session_service->add_order_item($product_id, $quantity);
            return $session_response;





        case 'unset_session':
            return $session_service->unset_session();






        case 'get_payment_by_id':
            $quickpay = new Quickpay();
            $endpoint->set_expected_body_properties(array('id'));
            return $quickpay->call_get_payment_by_id((int)$endpoint->body->id);





        case 'set_customer':
            $endpoint->set_expected_body_properties(
                array(
                    'fullname', 'phone', 'email',
                    'street', 'postal_code', 'city',
                    'cvr_number', 'company_name'
                )
            );

            $customer_details = (array)$endpoint->body;
            $session_service->set_customer($customer_details);
            return $session_service->set_customer($customer_details);







        default:
            $error_message = "Unknown functioncall: " . $endpoint->get_parameter->functioncall;
            new Error(__FILE__, $error_message, $fatal_error = true);
            break;
    }
}

echo json_encode(get_response(), JSON_PRETTY_PRINT);
