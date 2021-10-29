<?php
// ----- global ----- //
require_once __DIR__.'/../../global-requirements.php'; // _from_top_folder().

use vezit\classes\session\order\order_item as Order_Item;
use vezit\classes\session as Session;

// Starts session
if (session_status() === PHP_SESSION_NONE) {
  session_start();  
}


$session = new Session\Session();

// Imagen that this script is equal that someone is in the basket page and they have added these items.
$o_order_item_1 = new Order_Item\Order_Item("cat6 UTP Dataudtag RJ45 1-stik - Hvid", "77632", 2320, 6);
$session->order->set_order_item($o_order_item_1);
$o_order_item_2 = new Order_Item\Order_Item("cat 5e U/UTP Netværkskabel samler.", "CCGP89005WT", 960, 4);
$session->order->set_order_item($o_order_item_2);
$o_order_item_3 = new Order_Item\Order_Item("kabelsamler", "2312314", 1000, 14);
$session->order->set_order_item($o_order_item_3);

echo "<pre>" . json_encode($session, JSON_PRETTY_PRINT) . "</pre>";
$_SESSION["session"] = $session;
