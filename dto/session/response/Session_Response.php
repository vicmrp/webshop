<?php

namespace vezit\dto\session\response;

require __DIR__ . '/../../../global-requirements.php';

use vezit\dto\class\session\Session;

class Session_Response
{
    function __construct(public Session $session = new Session)
    {
    }
}
