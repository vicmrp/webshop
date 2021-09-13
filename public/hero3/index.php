<?php

// php scriptet echo'er en fil struktur som gør at du har en konsistent header og footer i pa din side


// ----- head ----- //
  // head-start.html indenholder default værdier
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
$page="hero3";

// fil lokationer
$gLocation = "../global/html";
$lLocation = ".";

// alle fil navn i variabler
// ----- head ----- //
  $gheadStart = "head-start.html";
  $lhead = "head.html";
  $gheadEnd = "head-end.html";
// ----- head ----- //
    // ----- body -----//
      // ----- header ----- //
        $gheader = "header.html";
      // ----- header ----- //

      // ----- hero (pagename) ----- //
        $lmain = "main.html";
      // ----- hero (pagename) ----- //

      // ----- footer ----- //
        $gfooter = "footer.html";
      // ----- footer ----- //
    // ----- body -----//
// ----- foot ----- //
  $gfootStart = "foot-start.html";
  $lfoot = "foot.html";
  $gfoodEnd = "foot-end.html";
// ----- foot ----- //

// ------ Denne del echo'er hele html siden ------ //
  // ----- head ----- //
    // head-start
    $tabs="";
    $contentLocation="$gLocation/$gheadStart";
    echo "$tabs<!-- $contentLocation -->\n";
    echo file_get_contents("$contentLocation");
    echo "\n$tabs<!-- $contentLocation -->\n\n\n\n";

    // head
    $tabs="\t";
    $contentLocation="$lLocation/$lhead";
    echo "$tabs<!-- $contentLocation -->\n";
    echo file_get_contents("$contentLocation");
    echo "\n$tabs<!-- $contentLocation -->\n\n\n\n";

    // head-end
    $tabs="";
    $contentLocation="$gLocation/$gheadEnd";
    echo "$tabs<!-- $contentLocation -->\n";
    echo file_get_contents("$contentLocation");
    echo "\n$tabs<!-- $contentLocation -->\n\n\n\n";
  // ----- head ----- //

    // ----- body -----//

      // ----- header ----- //
      // header
        $tabs="\t";
        $contentLocation="$gLocation/$gheader";
        echo "$tabs<!-- $contentLocation -->\n";
        echo file_get_contents("$contentLocation");
        echo "\n$tabs<!-- $contentLocation -->\n\n\n\n";
      // ----- header ----- //

      // ----- main ----- //
      // hero
        $tabs="\t";
        $contentLocation="$lLocation/$lmain";
        echo "$tabs<!-- $contentLocation -->\n";
        echo file_get_contents("$contentLocation");
        echo "\n$tabs<!-- $contentLocation -->\n\n\n\n";
      // ----- main ----- //

      // ----- footer ----- //
      // footer
        $tabs="\t";
        $contentLocation="$gLocation/$gfooter";
        echo "$tabs<!-- $contentLocation -->\n";
        echo file_get_contents("$contentLocation");
        echo "\n$tabs<!-- $contentLocation -->\n\n\n\n";
      // ----- footer ----- //
    // ----- body -----//

  // ----- foot ----- //
    // foot-start
    $tabs="";
    $contentLocation="$gLocation/$gfootStart";
    echo "$tabs<!-- $contentLocation -->\n";
    echo file_get_contents("$contentLocation");
    echo "\n$tabs<!-- $contentLocation -->\n\n\n\n";

    // foot
    $tabs="";
    $contentLocation="$lLocation/$lfoot";
    echo "$tabs<!-- $contentLocation -->\n";
    echo file_get_contents("$contentLocation");
    echo "\n$tabs<!-- $contentLocation -->\n\n\n\n";

    // foot-end
    $tabs="";
    $contentLocation="$gLocation/$gfoodEnd";
    echo "$tabs<!-- $contentLocation -->\n";
    echo file_get_contents("$contentLocation");
    echo "\n$tabs<!-- $contentLocation -->\n\n\n\n";
  // ----- foot ----- //
// ------ Denne del echo'er hele html siden ------ //