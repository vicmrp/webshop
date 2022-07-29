<?php

namespace vezit\dto\login_request;

class Login_Request
{
    public function __construct(
        public ?string $email     = null,
        public ?string $password  = null
    ) {
    }

    public function __set($name, $value)
    {
        throw new \Exception('Cant set!' . $name . ', ' . $value);
    }
}
