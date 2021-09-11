<?php
session_start();

// denne variable er navnet p?? php filen.
$page="createpc";


// ----- head ----- //
// head (<head>)
$tabs="";
$filename="./_aa_head-start.html";
echo "$tabs<!-- $filename -->\n";
echo file_get_contents("$filename");
echo "\n$tabs<!-- $filename -->\n\n\n\n";

// head-default
$tabs="\t";
$filename="./_ab__head-default.html";
echo "$tabs<!-- $filename -->\n";
echo file_get_contents("$filename");
echo "\n$tabs<!-- $filename -->\n\n\n\n";

// head-<page>
$tabs="\t";
$filename="./_ab_head-$page.html";
echo "$tabs<!-- $filename -->\n";
echo file_get_contents("$filename");
echo "\n$tabs<!-- $filename -->\n\n\n\n";

// head-end
$tabs="";
$filename="./_ac_head-end.html";
echo "$tabs<!-- $filename -->\n";
echo file_get_contents("$filename");
echo "\n$tabs<!-- $filename -->\n\n\n\n";
// ----- head ----- //

    // ----- body -----//
        // ----- header ----- //
        $tabs="\t";
        $filename="./_ba_header.html";
        echo "$tabs<!-- $filename -->\n";
        echo file_get_contents("$filename");
        echo "\n$tabs<!-- $filename -->\n\n\n\n";
        // ----- header ----- //

        // ----- main ----- //
        $tabs="\t";
        $filename="./_c_main-$page.html";
        echo "$tabs<!-- $filename -->\n";
        echo file_get_contents("$filename");
        echo "\n$tabs<!-- $filename -->\n\n\n\n";
        // ----- main ----- //

        // ----- footer ----- //
        $tabs="\t";
        $filename="./_d_footer.html";
        echo "$tabs<!-- $filename -->\n";
        echo file_get_contents("$filename");
        echo "\n$tabs<!-- $filename -->\n\n\n\n";
        // ----- footer ----- //
    // ----- body -----//

// foot
$tabs="";
$filename="./_ea_foot-start.html";
echo "$tabs<!-- $filename -->\n";
echo file_get_contents("$filename");
echo "\n$tabs<!-- $filename -->\n\n\n\n";

// foot-<page>
$tabs="";
$filename="./_eb_foot-$page.html";
echo "$tabs<!-- $filename test -->\n";
echo file_get_contents("$filename");
echo "\n$tabs<!-- $filename -->\n\n\n\n";

// foot-end
$tabs="";
$filename="./_ec_foot-end.html";
echo "$tabs<!-- $filename -->\n";
echo file_get_contents("$filename");
echo "\n$tabs<!-- $filename -->\n\n\n\n";