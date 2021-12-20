<?php

namespace vezit\_repositories\tspa_script;

require __DIR__.'/../../../global-requirements.php';



// test
// php -f _tests/repositories/tspa_script/test.php
$tspa_script = new Tspa_Script();
echo $tspa_script->get_main_script('DesktopStaffManagedComputersBYGInstitutter');