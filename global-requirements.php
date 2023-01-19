<?php
// Require link til den her fil
// require __DIR__.'/global-requirements.php';



// Globale variabler og funktioner
// Note en global kan ikke tilgas inde i et scope e.g. en funktion
// Brug her 'global' keyword for at kunne tilga.
// Dokumentation https://www.php.net/manual/en/language.variables.scope.php
$g_postnord_apikey      = file_get_contents(__DIR__ . '/secret/postnord_apikey');
$g_quickpay_apikey      = file_get_contents(__DIR__ . '/secret/quickpay_apikey');
$g_quickpay_privatekey  = file_get_contents(__DIR__ . '/secret/quickpay_privatekey');
$g_smtp_mail_credential = json_decode(file_get_contents(__DIR__ . '/secret/smtp_mail_credential.json'));
$g_db_conn              = json_decode(file_get_contents(__DIR__ . '/secret/db_conn.json'));
$g_order_id_length      = 20;

// misc funktioner
require_once 'library.php';

if (session_status() === PHP_SESSION_NONE) session_start();

g_get_all_namespaces($g_namespaces = ['classes', 'dto', 'entities', 'services', 'repositories', 'models', 'controllers', 'api']);
