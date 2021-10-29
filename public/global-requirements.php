<?php 
// Require link til den her fil
// require_once __DIR__.'/global-requirements.php';



// Globale variabler og funktioner
// Note en global kan ikke tilgas inde i et scope e.g. en funktion
// Brug her 'global' keyword for at kunne tilga.
// Dokumentation https://www.php.net/manual/en/language.variables.scope.php
// $g_my_global_var = 'Hello from global';
$g_postnord_apikey      = file_get_contents(__DIR__.'/../secret/postnord_apikey');
$g_quickpay_apikey      = file_get_contents(__DIR__.'/../secret/quickpay_apikey');
$g_quickpay_privatekey  = file_get_contents(__DIR__.'/../secret/quickpay_privatekey');
$g_smtp_mail_credential = json_decode(file_get_contents(__DIR__.'/../secret/smtp_mail_credential.json'));
$g_db_conn              = json_decode(file_get_contents(__DIR__.'/../secret/db_conn.json'));

// misc funktioner
require_once 'library.php';


// ----- namespaces - inkludere alle klasserne ----- //
$directories = new RecursiveDirectoryIterator(_from_top_folder().'/classes');
foreach (new RecursiveIteratorIterator($directories) as $filename => $file)
{ 
  if (!is_dir($filename)) require_once $filename;  
}
