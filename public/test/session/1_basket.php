<?php
// ----- global ----- //
require_once __DIR__.'/../../global-requirements.php'; // _from_top_folder().



// use vezit\classes\session\customer as Customer;
// use vezit\classes\session\shipment as Shipment;
// use vezit\classes\session\order as Order;
// use vezit\classes\session\order\order_status as Order_Status;
use vezit\classes\session as Session;


session_start();

$session = null;
$test = new Session\Session();
echo json_encode($test, JSON_PRETTY_PRINT);

// Skal forstille at du har puttet ting i din kurv

// // Basket
// $o_order_item_1 = new Order_Status\Order_Item("cat6 UTP Dataudtag RJ45 1-stik - Hvid", "77632", 2320, 6);
// $o_order_item_2 = new Order_Status\Order_Item("cat 5e U/UTP Netværkskabel samler.", "CCGP89005WT", 960, 4);
// $o_list_order_item = [$o_order_item_1,$o_order_item_2];

// // __construct($order_id, $order_status, $order_item)
// $o_order = new Order\Order('1234id', null, $o_list_order_item);

// // Session
// // __construct($session_id, $customer, $shipment, $order)
// $session_id = strval(rand(1000000,9999999));
// $session = new Session\Session($session_id, null, null, $o_order);
// $_SESSION["session"] = $session;

// echo json_encode($session, JSON_PRETTY_PRINT) . PHP_EOL;
