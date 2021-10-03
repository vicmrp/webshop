<?php
// ----- global ----- //
require_once __DIR__.'/../../global-requirements.php'; // _from_top_folder().

use vezit\classes\session\order\order_item as Order_Item;
use vezit\classes\session as Session;


session_start();


$session = new Session\Session();

// Skal forstille at du har puttet ting i din kurv.
// Du ffar lige nu præsenteret en en liste ef de ting som du vik købe.
// Du er ved ga til næste side (2_customer.php)

$o_order_item_1 = new Order_Item\Order_Item("cat6 UTP Dataudtag RJ45 1-stik - Hvid", "77632", 2320, 6);
$o_order_item_2 = new Order_Item\Order_Item("cat 5e U/UTP Netværkskabel samler.", "CCGP89005WT", 960, 4);
$session->order->set_order_item($o_order_item_1);
$session->order->set_order_item($o_order_item_2);

// printer ud sa du kan se pa skærm
echo json_encode($session, JSON_PRETTY_PRINT);
$_SESSION["session"] = $session;
// Du klikker dig nu videre til indtastning af kundeoplysninger
