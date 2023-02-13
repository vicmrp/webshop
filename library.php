<?php
// This file is acccessible from every class in this project. It is accessed through global-requirements.php
// This means that every class has access to all global variables, function.
// all global function is namespaced with "g_".




// -------------- g_generate_random_string(int $length = 10, bool $lowercase = true) : string -------------- //

function g_generate_random_string(int $length = 10, bool $lowercase = true)
{
    $characters = '23456789abcdefghkmnpqrstuvwxyzABCDEFGHJKMNOPQRSTUVWXYZ'; // uden ijlo01IL
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    if ($lowercase) return strtolower($randomString);
    else            return $randomString;
}



// denne funtion benytter at en dirname(__FILE__) retunere
// den fulde sti hen til der hvor filen ligger
// derfor sa længe at library.php ligger i root (top folderen)
// sa kan du benytte denne funtion til et relativt folder punkt

// returns the full path to the top folder of the project
// If the project is located here /var/www/victorswebframework.local
// Then the function will return /var/www/victorswebframework.local
function g_from_top_folder() : string 
{
    return dirname(__FILE__);
}



// Define a function called "g_scandir" which takes in a string argument "$dir" and returns an array
function g_scandir(string $dir): array
{
    // Use the "scandir" function to get a list of all files and directories in "$dir"
    // Use "array_diff" to remove "." and ".." from the list, as they are not useful
    // Use "array_values" to re-index the resulting array

    // array_values(); for example, given an array $array = array('a' => 1, 'b' => 2, 'c' => 3), calling array_values($array) would return [1, 2, 3]. 
    // The original keys are lost, and the values are re-indexed starting from zero.
    return array_values(array_diff(scandir($dir), array('..', '.')));


}





// -------------- g_get_all_namespaces(array $folders) : void -------------- //
// This function will require all classes in the given folders and subfolders
// This automates access to namespaces and classes
// Now access a namespace, simply require global-requirements.php
function g_get_all_namespaces(array $folders) : void
{

    // handles folders notation for windows and linux
    switch (PHP_OS) {
        case 'WINNT':
            $slash = '\\';
            break;
        case 'Linux':
            $slash = '/';
            break;
    }


    // Loops through all folders and subfolders given in the array
    // and requires all files, which should be a class.
    foreach ($folders as $folder) {
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
