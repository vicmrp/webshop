<?php

require __DIR__.'/../../global-requirements.php';
use vezit\classes\mail as Mail;
use vezit\services\session_service\Session_Service;
use vezit\repositories\session_repository\Session_Repository;
use vezit\services\quickpay_service\Quickpay_Service;
use vezit\entities\Session;
use vezit\entities\Sessions;
use vezit\entities\Session_Order_Items;
use vezit\entities\Session_Order_Item;


// Check if order_id is set
if (isset($_GET['order_id'])) {

    $session_service = Session_Service::get_instance();

    // Get session
    $session_before_update = $session_service->get_session($_GET['order_id'])->session;

    // Get quickpay payment
    $quickpay_service = Quickpay_Service::get_instance();
    $quickpay_payment = $quickpay_service->get_payment($session_before_update->order->status->payment->quickpay_id);

    // Check if payment is accepted
    // Check also that invoice has not been sent to customer.
    // This is to prevent the customer from getting multiple emails.
    if ($quickpay_payment->accepted == true && $session_before_update->order->status->email->invoice_sent_to_customer == false) {

        $session_before_update->order->status->payment->accepted = true;
        $session_before_update->order->status->email->invoice_sent_to_customer = true;


        // send email to customer
        (array)$recipients = array(array("victor.reipur@gmail.com", "Victor Reipur"));
        (string)$subject = "Tak for dit køb :) ordre id: {$session_before_update->order->id}";
        (string)$body = "This is the HTML message body <b>in bold!</b>";
        Mail\Mail::send_mail($recipients, $subject, $body, array('../../secret/victorsbog.pdf'));


        // Capture payment in quickpay
        $quickpay_service->capture_payment($session_before_update->order->status->payment->quickpay_id, 14900);


        // Update session to database
        $session_repository = Session_Repository::get_instance();
        $session_entity = $session_repository->get_by_order_id($order_id = $session_before_update->order->id);
        $session_entity->order_status_payment_accepted = true;
        $session_entity->order_status_email_invoice_sent_to_customer = true;
        $session_repository->update($pk = $session_entity->session_pk, $session_entity = $session_entity);




        global $g_domain_name;
        // Redirect to callback page
        header("Location: https://$g_domain_name/callback/?order_id={$session_before_update->order->id}");

    } else {

        // in the callback page you can show a message to the customer that the payment was not accepted
        header("Location: https://$g_domain_name/callback/?order_id={$session_before_update->order->id}");
    }

}






























// if ($response_from_quickpay->accepted == true) {
//     $session_to_update->order_status_payment_accepted = true;
//     $session_to_update->order_status_email_invoice_sent_to_customer = true;

//     // send email to customer
//     (array)$recipients = array(array("victor.reipur@gmail.com", "Victor Reipur"));
//     (string)$subject = "Tak for dit køb :) ordre id: $session->order_id";
//     (string)$body = "This is the HTML message body <b>in bold!</b>";
//     Mail\Mail::send_mail($recipients, $subject, $body, array('../../secret/victorsbog.pdf'));


//     $session_repository->update($session_to_update);






// }