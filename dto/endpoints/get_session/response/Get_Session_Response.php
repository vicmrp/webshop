<?php namespace vezit\dto\endpoints\get_session\response;
use vezit\dto\internal_dtos\session\Session;

class Get_Session_Response
{
    public function __construct(public Session $session = new Session()) {}
}
