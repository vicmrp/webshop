<?php

// php scriptet echo'er en fil struktur som g?r at du har en konsistent header og footer i pa din side


// ----- head ----- //
  // head-start.html indenholder default v?rdier
  // head-hero.html hero content
  // head-end.html  
// ----- head ----- //
// ----- body -----//
    // header.html
    // hero.html
    // footer.html
// ----- body -----//
// ----- foot ----- //
  // foot-start.html
  // foot-hero.html
  // foot-end.html
// ----- foot ----- //

// denne variable er navnet pa php filen.
// $fileNameOfThisFile="hero";

// fil lokationer
$gLocation = "../global/html";
$lLocation = ".";

// alle fil navn i variabler
// ----- head ----- //
  $gHeadStart = "head-start.html";
  $lHead = "head.html";
  $gHeadEnd = "head-end.html";
// ----- head ----- //
    // ----- body -----//
      // ----- header ----- //
        $gHeader = "header.html";
      // ----- header ----- //

      // ----- hero (pagename) ----- //
        $lMain = "main.html";
      // ----- hero (pagename) ----- //

      // ----- footer ----- //
        $gFooter = "footer.html";
      // ----- footer ----- //
    // ----- body -----//
// ----- foot ----- //
  $gFootStart = "foot-start.html";
  $lFoot = "foot.html";
  $gFoodEnd = "foot-end.html";
// ----- foot ----- //

// ------ Denne del echo'er hele html siden ------ //
  // ----- head ----- //
    // head-start
    $tabs="";
    $contentLocation="$gLocation/$gHeadStart";
    echo "$tabs<!-- $contentLocation -->\n";
    echo file_get_contents("$contentLocation");
    echo "\n$tabs<!-- $contentLocation -->\n\n\n\n";

    // head
    $tabs="\t";
    $contentLocation="$lLocation/$lHead";
    echo "$tabs<!-- $contentLocation -->\n";
    echo file_get_contents("$contentLocation");
    echo "\n$tabs<!-- $contentLocation -->\n\n\n\n";

    // head-end
    $tabs="";
    $contentLocation="$gLocation/$gHeadEnd";
    echo "$tabs<!-- $contentLocation -->\n";
    echo file_get_contents("$contentLocation");
    echo "\n$tabs<!-- $contentLocation -->\n\n\n\n";
  // ----- head ----- //

    // ----- body -----//

      // ----- header ----- //
      // header
        $tabs="\t";
        $contentLocation="$gLocation/$gHeader";
        echo "$tabs<!-- $contentLocation -->\n";
        echo file_get_contents("$contentLocation");
        echo "\n$tabs<!-- $contentLocation -->\n\n\n\n";
      // ----- header ----- //

      // ----- main ----- //
      // hero
        $tabs="\t";
        $contentLocation="$lLocation/$lMain";
        echo "$tabs<!-- $contentLocation -->\n";
        echo file_get_contents("$contentLocation");
        echo "\n$tabs<!-- $contentLocation -->\n\n\n\n";
      // ----- main ----- //

      // ----- footer ----- //
      // footer
        $tabs="\t";
        $contentLocation="$gLocation/$gFooter";
        echo "$tabs<!-- $contentLocation -->\n";
        echo file_get_contents("$contentLocation");
        echo "\n$tabs<!-- $contentLocation -->\n\n\n\n";
      // ----- footer ----- //
    // ----- body -----//

  // ----- foot ----- //
    // foot-start
    $tabs="";
    $contentLocation="$gLocation/$gFootStart";
    echo "$tabs<!-- $contentLocation -->\n";
    echo file_get_contents("$contentLocation");
    echo "\n$tabs<!-- $contentLocation -->\n\n\n\n";

    // foot
    $tabs="";
    $contentLocation="$lLocation/$lFoot";
    echo "$tabs<!-- $contentLocation -->\n";
    echo file_get_contents("$contentLocation");
    echo "\n$tabs<!-- $contentLocation -->\n\n\n\n";

    // foot-end
    $tabs="";
    $contentLocation="$gLocation/$gFoodEnd";
    echo "$tabs<!-- $contentLocation -->\n";
    echo file_get_contents("$contentLocation");
    echo "\n$tabs<!-- $contentLocation -->\n\n\n\n";
  // ----- foot ----- //
// ------ Denne del echo'er hele html siden ------ //