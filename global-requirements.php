<?php
// This file is included in every class in this project.
// This means that every class has access to all global variables and all other classes.


// It is used to include global requirements and to define global variables.
// global requirements such as all classes, functions, etc. should be included here.
// every class in this project included this file. That means that every class has access to all global variables and all other classes.
// Here is an example of how to include global requirements in a class:
// require __DIR__.'/global-requirements.php';






// ------- Global variables ------- //
// All global variables should be namespaced with "g_".
// This is the place all global variables should be defined.
// It is typically used to store credentials and other sensitive information.
// Things that should not be stored in a public repository.
// If you want to access a global variable in a class or scope, you can do it like this:
// global $g_postnord_apikey;
// Now $g_postnord_apikey is defined in this class or scope.
// echo $g_postnord_apikey  >> <API-KEY>;


// domain name based on the parent folder name
$g_domain_name = basename(__DIR__);



// A boolean that determines if the website is in sandbox mode or not.
// Other global variables are set based on this variable.
//
// it is determined by the content of the file secret/sandbox.json
// if the file contains the following:
// {
//    "sandbox_mode_enabled": true
// }
// then $g_sandbox_mode_enabled is true
$g_sandbox_mode_enabled = (bool)json_decode(file_get_contents(__DIR__ . '/secret/sandbox.json'), false)->sandbox_mode_enabled;



// if $g_sandbox_mode_enabled is true then set $g_quickpay_apikey to quickpay_apikey_sandbox'
// else set $g_quickpay_apikey to quickpay_apikey
$g_quickpay_apikey = file_get_contents(__DIR__ . '/secret/quickpay_apikey' . ($g_sandbox_mode_enabled ? '_sandbox' : ''));

// Set the current database version
$g_db_version = "v1_0_1";

// Check if the sandbox mode is enabled
$g_db_conn_file = '/secret/db_conn.json';
if ($g_sandbox_mode_enabled) {
// If sandbox mode is enabled, use the sandbox database connection configuration file
$g_db_conn_file = '/secret/db_conn_sandbox.json';
}

// Load the database connection configuration from the file
$g_db_conn = json_decode(file_get_contents(__DIR__ . $g_db_conn_file));

// Modify the database name to include the database version
// For example, the database name will become user_vezit_net_v1_0_0
$g_db_conn->dbname .= '_' . $g_db_version;


$g_smtp_mail_credential = json_decode(file_get_contents(__DIR__ . '/secret/smtp_mail_credential.json'));
$g_order_id_length      = 20; // The length of the order id
// ------- Global variables ------- //

// Contains all global functions
require_once 'library.php';


// ---------- script start ---------- //

// If session is not started, start it.
if (session_status() === PHP_SESSION_NONE) session_start();


// Enables all classes to be accessed without the need to require them. As long as they require global-requirements.php
g_get_all_namespaces($g_namespaces = ['classes', 'dto', 'entities', 'services', 'repositories', 'models', 'controllers', 'api']);

// ---------- script end ---------- //