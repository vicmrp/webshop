<?php 
// Require link til den her fil
// require_once __DIR__.'/global-requirements.php';


// Globale variabler og funktioner
// Note en global kan ikke tilgas inde i et scope e.g. en funktion
// Brug her 'global' keyword for at kunne tilga.
// Dokumentation https://www.php.net/manual/en/language.variables.scope.php
// $g_my_global_var = 'Hello from global';
$g_postnord_apikey = file_get_contents(__DIR__.'/../secret/postnord_apikey');
$g_quickpay_apikey = file_get_contents(__DIR__.'/../secret/quickpay_apikey');
$g_quickpay_privatekey = file_get_contents(__DIR__.'/../secret/quickpay_privatekey');
$g_smtp_mail_credential = json_decode(file_get_contents(__DIR__.'/../secret/smtp_mail_credential.json'));

require_once 'library.php';


// ----- namespaces - inkludere alle klasserne ----- //
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
require_once _from_top_folder().'/classes/mail/Mail.php';

