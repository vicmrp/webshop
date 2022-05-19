<?php namespace vezit\dto;
use vezit\models\session\Session;

class Session_Response
{
    public function __construct(public Session $session = new Session()) {}
}
