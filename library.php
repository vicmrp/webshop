<?php

//TODO lav en utility class saa library.php bliver Objekt Orienteret.

// Alle globale functioner som ikke er en del af en klasse
// skal ligge i denne fil,

// globale funtioner skal have underscore foran

function g_generate_random_string($length = 10)
{
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
function g_from_top_folder()
{
    return dirname(__FILE__);
}



function g_scandir(string $dir): array
{
    return array_values(array_diff(scandir($dir), array('..', '.')));
}



function _return_evaluated_user_credentials()
{
}

function g_get_all_namespaces(array $folders)
{
    switch (PHP_OS) {
        case 'WINNT':
            $slash = '\\';
            break;
        case 'Linux':
            $slash = '/';
            break;
    }

    foreach ($folders as $folder) {
        // ----- namespaces - inkludere alle klasserne ----- //
        $directories = new RecursiveDirectoryIterator(g_from_top_folder() . $slash . $folder);
        foreach (new RecursiveIteratorIterator($directories) as $filename) {
            try {
                if (!is_dir($filename)) require_once $filename;
            } catch (\Throwable $th) {
                throw $th;
            }
        }
    }
}


function g_find_object_by_id($id, $array_of_objects)
{

    if ( isset( $array_of_objects[$id] ) ) {
        return $array_of_objects[$id];
    }

    return false;
}










function g_generate_dto_from_json(object $data, $dto) {

    $dto = new $dto();
    $std_object = $data;
    foreach ($std_object as $std_object_property => $std_object_value) {
        foreach ($dto as $dto_object_property => $dto_object_value) {
            if ($std_object_property == $dto_object_property)
                $dto->$dto_object_property = $std_object_value;
        }
    }
    return $dto;
}

