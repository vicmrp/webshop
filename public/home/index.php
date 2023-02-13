<?php

  $head_start  = "head-start.html";
  $head        = "head.html";
  $head_end    = "head-end.html";
  $header      = "header.html";
  $main        = "main.html";
  $footer      = "footer.html";
  $foot        = "foot.html";
  $foot_end    = "foot-end.html";


  // php scriptet echo'er en fil struktur som gør at du har en konsistent header og footer i pa din side

  // fil lokationer
  $global_file_location = "../vezit-service-global/html";
  $local_file_location = ".";

  // ------ Denne del echo'er hele html siden ------ //
  // ----- head ----- //
  // head-start
  $tabs="";
  $contentLocation="$global_file_location/$head_start";
  echo "$tabs<!-- $contentLocation -->" . PHP_EOL;
  echo file_get_contents("$contentLocation");
  echo PHP_EOL . "$tabs<!-- $contentLocation -->" . PHP_EOL;

  // head
  $tabs="	";
  $contentLocation="$local_file_location/$head";
  echo "$tabs<!-- $contentLocation -->" . PHP_EOL;
  echo file_get_contents("$contentLocation");
  echo PHP_EOL . "$tabs<!-- $contentLocation -->";

  // head-end
  $tabs="";
  $contentLocation="$global_file_location/$head_end";
  echo PHP_EOL . "$tabs<!-- $contentLocation -->" . PHP_EOL;
  echo file_get_contents("$contentLocation");
  echo PHP_EOL . "$tabs<!-- $contentLocation -->";
  // ----- head ----- //
  // ----- body -----//
    // ----- header ----- //
    $tabs="	";
    $contentLocation="$global_file_location/$header";
    echo PHP_EOL . "$tabs<!-- $contentLocation -->" . PHP_EOL;
    echo file_get_contents("$contentLocation");
    echo PHP_EOL . "$tabs<!-- $contentLocation -->";
    // ----- header ----- //

    // ----- main ----- //
    $tabs="	";
    $contentLocation="$local_file_location/$main";
    echo PHP_EOL . "$tabs<!-- $contentLocation -->" . PHP_EOL;
    echo file_get_contents("$contentLocation");
    echo PHP_EOL . "$tabs<!-- $contentLocation -->";
    // ----- main ----- //

    // ----- footer ----- //
    $tabs="	";
    $contentLocation="$global_file_location/$footer";
    echo PHP_EOL . "$tabs<!-- $contentLocation -->" . PHP_EOL;
    echo file_get_contents("$contentLocation");
    echo PHP_EOL . "$tabs<!-- $contentLocation -->";
    // ----- footer ----- //
  // ----- body ----- //
  // ----- foot ----- //
  // foot-end
  $tabs="";
  $contentLocation="$global_file_location/$foot_end";
  echo PHP_EOL . "$tabs<!-- $contentLocation -->" . PHP_EOL;
  echo file_get_contents("$contentLocation");
  echo PHP_EOL . "$tabs<!-- $contentLocation -->";
  // ----- foot ----- //
  