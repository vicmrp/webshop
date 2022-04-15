<?php

namespace vezit\classes\api\dawa;

# php -f tests/classes/api/dawa/Dawa-call_get_sanitized_address.php


require_once __DIR__.'/../../../../global-requirements.php';



var_dump(Dawa::call_get_sanitized_address('Vinkelvej 12D, 3tv', "2800"));