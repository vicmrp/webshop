<?php
// Require link til den her fil
// require __DIR__.'/global-requirements.php';



// Globale variabler og funktioner
// Note en global kan ikke tilgas inde i et scope e.g. en funktion
// Brug her 'global' keyword for at kunne tilga.
// Dokumentation https://www.php.net/manual/en/language.variables.scope.php

// Global variable that contains the domain name of the website based on the parent folder name
// e.g. if parent folder is 'sandbox.vezit.net' then set $g_domain_name to 'sandbox.vezit.net'
// else set $g_domain_name to 'vezit.net'
$g_domain_name = basename(__DIR__);

// if parent folder is 'sandbox.vezit.net' then set $g_quickpay_apikey to quickpay_apikey_sandbox'
// else set $g_quickpay_apikey to quickpay_apikey
$g_quickpay_apikey = file_get_contents(__DIR__ . '/secret/quickpay_apikey' . ($g_domain_name === 'sandbox.vezit.net' ? '_sandbox' : ''));

// if parent folder is 'sandbox.vezit.net' then set $g_db_conn to db_conn_sandbox'
// else set $g_db_conn to db_conn
$g_db_conn = json_decode(file_get_contents(__DIR__ . '/secret/db_conn' . ($g_domain_name === 'sandbox.vezit.net' ? '_sandbox' : '') . '.json'));

$g_smtp_mail_credential = json_decode(file_get_contents(__DIR__ . '/secret/smtp_mail_credential.json'));
$g_order_id_length      = 20;

// misc funktioner
require_once 'library.php';

if (session_status() === PHP_SESSION_NONE) session_start();

g_get_all_namespaces($g_namespaces = ['classes', 'dto', 'entities', 'services', 'repositories', 'models', 'controllers', 'api']);
