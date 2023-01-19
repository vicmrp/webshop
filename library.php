<?php

//TODO lav en utility class saa library.php bliver Objekt Orienteret.

// Alle globale functioner som ikke er en del af en klasse
// skal ligge i denne fil,

// globale funtioner skal have underscore foran

function g_generate_random_string(int $length = 10, bool $lowercase = true)
{
    // $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $characters = '23456789abcdefghkmnpqrstuvwxyzABCDEFGHJKMNOPQRSTUVWXYZ'; // uden ijlo01IL
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    if ($lowercase) return strtolower($randomString);
    else            return $randomString;
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









// TODO skal slettes, skal ikke bruges.
// function g_generate_flat_dto_from_web_request(object $data, $dto) {

//     $dto = new $dto();
//     $std_object = $data;
//     foreach ($std_object as $std_object_property => $std_object_value) {
//         foreach ($dto as $dto_object_property => $dto_object_value) {
//             if ($std_object_property == $dto_object_property)
//                 $dto->$dto_object_property = $std_object_value;
//         }
//     }
//     return $dto;
// }



function g_generate_multidimensional_dto_from_web_request(object $object_to_be_converted, $class_type, bool $null_is_not_allowed = true) {

    $dto = new $class_type;


    foreach ($object_to_be_converted as $object_to_be_converted_property => $object_to_be_converted_value) {


        foreach ($dto as $dto_object_property => $dto_object_value) {


            $is_a_sub_class = ($object_to_be_converted_value instanceof stdClass) ? true : false;
            $is_array     = is_array($object_to_be_converted_value);


            if ($is_a_sub_class) {

                $dto->$object_to_be_converted_property = g_generate_multidimensional_dto_from_web_request(
                    $object_to_be_converted_value
                   ,$dto->$object_to_be_converted_property::class
                   ,$null_is_not_allowed
                );

                break;
            }


            $object_to_be_converted__property_is_the_same_as__dto_object_property =
                ($object_to_be_converted_property === $dto_object_property)
                ? true
                : false;

            if ($object_to_be_converted__property_is_the_same_as__dto_object_property) {

                if ($null_is_not_allowed && null === $object_to_be_converted_value) {
                    throw new Exception("Null is not acceptable", 1);
                }

                $dto->$object_to_be_converted_property = $object_to_be_converted_value;
                break;
            }
        }
    }

    return $dto;
}
