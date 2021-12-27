<?php
namespace vezit\classes\session;
use vezit\classes\session\order\order_item as Order_Item;

# php -f tests/classes/session/Session-Order-add_order_item.php

require __DIR__.'/../../../global-requirements.php';

$session = new Session();

$product_id = 1;
$quantity = 2;

$o_order_item_1 = new Order_Item\Order_Item("cat6 UTP Dataudtag RJ45 1-stik - Hvid", "77632", 2320, 6);
$session->order->add_order_item($o_order_item_1);

echo json_encode($session, JSON_PRETTY_PRINT);