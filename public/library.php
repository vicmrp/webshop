<?php

// Alle globale functioner som ikke er en del af en klasse
// skal ligge i denne fil,

// globale funtioner skal have underscore foran

function _generate_random_string($length = 10) {
    // $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $characters = '23456789abcdefghkmnpqrstuvwxyzABCDEFGHJKMNOPQRSTUVWXYZ'; // uden ijlo01IL
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}








// -------------- _to_top_folder($top_folder) : string '../../' -------------- //
// Denne funtion kan automatisk definere finde ud af hvor
// mange undermapper den en fil ligger.
// api/quickpay/callback.php skal require 
// classes/api/quickpay
//
// Derfor skal det sta saledes:
// require '../../'classes/api/quickpay

// implementering
// looper fra nederste submappe op imod target mappe (puplic)
// og tæller for hvert hop op ad.
// I vores eksempel hopper vi to gange op. 
// Functionen hvil altsa retunere en string '../../'

// svagheder. du ma ikke have en under mappe som har 
// samme navn som root folder.

// parameter (root_folder)
// function _to_top_folder($top_folder) 
// {
//     return dirname(__FILE__);
// }
// -------------- _to_top_folder($top_folder) : string '../../' -------------- //


// denne funtion benytter at en dirname(__FILE__) retunere 
// den fulde sti hen til der hvor filen ligger
// derfor sa længe at library.php ligger i root (top folderen)
// sa kan du benytte denne funtion til et relativt folder punkt
function _from_top_folder()
{
    return dirname(__FILE__);
}