<?php

namespace vezit\dto\session_response;

use vezit\models\session\Session;

class Session_Response
{
    public function __construct(public Session $session = new Session())
    {

    }

    public function __set($name, $value)
    {
        throw new \Exception('Cant set!' . $name . ', ' . $value);
    }
}
