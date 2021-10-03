<?php 
require_once 'library.php';

// ----- namespaces ----- //
require_once _from_top_folder().'/classes/session/customer/address/Address.php';
require_once _from_top_folder().'/classes/session/customer/company/Company.php';
require_once _from_top_folder().'/classes/session/customer/contact/Contact.php';
require_once _from_top_folder().'/classes/session/customer/Customer.php';
require_once _from_top_folder().'/classes/session/shipment/address/Address.php';
require_once _from_top_folder().'/classes/session/shipment/Shipment.php';
require_once _from_top_folder().'/classes/session/order/Order.php';
require_once _from_top_folder().'/classes/session/order/order_item/Order_Item.php';
require_once _from_top_folder().'/classes/session/order/order_status/email/Email.php';
require_once _from_top_folder().'/classes/session/order/order_status/Order_Status.php';
require_once _from_top_folder().'/classes/session/order/order_status/payment/Payment.php';
require_once _from_top_folder().'/classes/session/Session.php';
require_once _from_top_folder().'/classes/api/quickpay/Quickpay.php';
require_once _from_top_folder().'/classes/api/postnord/Postnord.php';
require_once _from_top_folder().'/classes/api/dawa/Dawa.php';