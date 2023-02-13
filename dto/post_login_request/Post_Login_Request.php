<?php

namespace vezit\dto\post_login_request;

class Post_Login_Request
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
