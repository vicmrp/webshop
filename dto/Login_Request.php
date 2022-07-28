<?php

namespace vezit\dto;

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
