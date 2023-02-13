<?php

namespace vezit\dto\get_session_response;

use vezit\models\session\Session;
use JsonSerializable;

class Get_Session_Response implements JsonSerializable
{
    public function __construct(public Session $session = new Session())
    {

    }

    public function __set($name, $value)
    {
        throw new \Exception('Cant set!' . $name . ', ' . $value);
    }


    # Exclude/Modify model model properties
    public function jsonSerialize() : mixed
    {
        unset($this->session->order->id);
        return get_object_vars($this);
    }
}
