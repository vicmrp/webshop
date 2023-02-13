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

$g_smtp_mail_credential = null;
$g_db_conn              = json_decode(file_get_contents(__DIR__ . '/secret/db_conn.json'));
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