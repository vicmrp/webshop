<?php

// var_dump($argc);
// var_dump($argv);

// php -f create_page.php hero
$pagename = $argv[1];

// if $page_name is null or empty
if (empty($pagename)) {
    die("No pagename given");
}

$forbidden_names = ['.vscode', 'vezit-service-callbacks', 'vezit-service-api', 'vezit-service-global', 'vezit-service-img', 'vezit-service-test'];

array_walk($forbidden_names, function ($item) {
    global $pagename;
    if (strtolower($pagename) == strtolower($item)) {
        die("Forbidden name: $pagename");
    }
});

$page_location = array(
    "location_relativ_to_this_script" => __DIR__ . "/public",
    "global_file_location", "../vezit-service-global/html",
    "local_file_location", "."
);

$subpages_filenames = array(
    // ----- head ----- //
    "head_start" => "head-start.html",
    "head" => "head.html",
    "head_end" => "head-end.html",
    // ----- head ----- //
    // ----- body -----//
    // ----- header ----- //
    "header" => "header.html",
    // ----- header ----- //

    // ----- hero (pagename) ----- //
    "main" => "main.html",
    // ----- hero (pagename) ----- //

    // ----- footer ----- //
    "footer" => "footer.html",
    // ----- footer ----- //
    // ----- body -----//
    // ----- foot ----- //
    "foot" => "foot.html",
    "foot_end" => "foot-end.html"
    // ----- foot ----- //
);



function create_page_folder($path): int
{

    if (file_exists(("$path")))
    {
        if (PHP_OS == 'Linux') {
            shell_exec("rm -r $path");
            mkdir("$path", 0770, true);
            return 0;
        }
        die ("$path already exists");
    }
    mkdir("$path", 0770, true);
    return 0;
}


function create_index_page($path, $subpages_filenames): void
{



    $head_start = $subpages_filenames["head_start"];
    $head       = $subpages_filenames["head"];
    $head_end   = $subpages_filenames["head_end"];
    $header     = $subpages_filenames["header"];
    $main       = $subpages_filenames["main"];
    $footer     = $subpages_filenames["footer"];
    $foot       = $subpages_filenames["foot"];
    $foot_end   = $subpages_filenames["foot_end"];


    $index_page_content = "<?php

  \$head_start  = \"$head_start\";
  \$head        = \"$head\";
  \$head_end    = \"$head_end\";
  \$header      = \"$header\";
  \$main        = \"$main\";
  \$footer      = \"$footer\";
  \$foot        = \"$foot\";
  \$foot_end    = \"$foot_end\";


  // php scriptet echo'er en fil struktur som gør at du har en konsistent header og footer i pa din side

  // fil lokationer
  \$global_file_location = \"../vezit-service-global/html\";
  \$local_file_location = \".\";

  // ------ Denne del echo'er hele html siden ------ //
  // ----- head ----- //
  // head-start
  \$tabs=\"\";
  \$contentLocation=\"\$global_file_location/\$head_start\";
  echo \"\$tabs<!-- \$contentLocation -->\" . PHP_EOL;
  echo file_get_contents(\"\$contentLocation\");
  echo PHP_EOL . \"\$tabs<!-- \$contentLocation -->\" . PHP_EOL;

  // head
  \$tabs=\"\t\";
  \$contentLocation=\"\$local_file_location/\$head\";
  echo \"\$tabs<!-- \$contentLocation -->\" . PHP_EOL;
  echo file_get_contents(\"\$contentLocation\");
  echo PHP_EOL . \"\$tabs<!-- \$contentLocation -->\";

  // head-end
  \$tabs=\"\";
  \$contentLocation=\"\$global_file_location/\$head_end\";
  echo PHP_EOL . \"\$tabs<!-- \$contentLocation -->\" . PHP_EOL;
  echo file_get_contents(\"\$contentLocation\");
  echo PHP_EOL . \"\$tabs<!-- \$contentLocation -->\";
  // ----- head ----- //
  // ----- body -----//
    // ----- header ----- //
    \$tabs=\"\t\";
    \$contentLocation=\"\$global_file_location/\$header\";
    echo PHP_EOL . \"\$tabs<!-- \$contentLocation -->\" . PHP_EOL;
    echo file_get_contents(\"\$contentLocation\");
    echo PHP_EOL . \"\$tabs<!-- \$contentLocation -->\";
    // ----- header ----- //

    // ----- main ----- //
    \$tabs=\"\t\";
    \$contentLocation=\"\$local_file_location/\$main\";
    echo PHP_EOL . \"\$tabs<!-- \$contentLocation -->\" . PHP_EOL;
    echo file_get_contents(\"\$contentLocation\");
    echo PHP_EOL . \"\$tabs<!-- \$contentLocation -->\";
    // ----- main ----- //

    // ----- footer ----- //
    \$tabs=\"\t\";
    \$contentLocation=\"\$global_file_location/\$footer\";
    echo PHP_EOL . \"\$tabs<!-- \$contentLocation -->\" . PHP_EOL;
    echo file_get_contents(\"\$contentLocation\");
    echo PHP_EOL . \"\$tabs<!-- \$contentLocation -->\";
    // ----- footer ----- //
  // ----- body ----- //
  // ----- foot ----- //
  // foot-end
  \$tabs=\"\";
  \$contentLocation=\"\$global_file_location/\$foot_end\";
  echo PHP_EOL . \"\$tabs<!-- \$contentLocation -->\" . PHP_EOL;
  echo file_get_contents(\"\$contentLocation\");
  echo PHP_EOL . \"\$tabs<!-- \$contentLocation -->\";
  // ----- foot ----- //
  ";

    file_put_contents("$path/index.php", $index_page_content);
}

function create_pages($path, $pagename, $subpages_filenames)
{



    $head       = $subpages_filenames["head"];
    $main       = $subpages_filenames["main"];

    $indentation_spaces = "\x20\x20\x20\x20";
    $head_content = "$indentation_spaces<title>$pagename</title>
$indentation_spaces<link rel='preconnect' href='https://fonts.gstatic.com'>
$indentation_spaces<link href='https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;1,100&display=swap' rel='stylesheet'>
$indentation_spaces<link href='./style.css' rel='stylesheet'/>";
    file_put_contents("$path/$head", $head_content);


    $indentation_spaces = "\x20\x20\x20\x20";
    $main_content = "$indentation_spaces<main id='main'>
$indentation_spaces  <h1>Hello World!</h1>
$indentation_spaces</main>";
    file_put_contents("$path/$main", $main_content);



    $javascript_content = file_get_contents(__DIR__ . "/templates/create_page/main.js");
    file_put_contents("$path/main.js", $javascript_content);
    $style_content = file_get_contents(__DIR__ . "/templates/create_page/style.css");
    file_put_contents("$path/style.css", $style_content);
}



$path = $page_location['location_relativ_to_this_script'] . '/' . $pagename;
create_page_folder($path);
create_index_page($path, $subpages_filenames);
create_pages($path, $pagename, $subpages_filenames);

if (PHP_OS == 'Linux') {
    // Set permissions
    shell_exec("chmod 770 -R $path");
    // Set owner www-data:www-data
    shell_exec("chown www-data:www-data -R $path");
}