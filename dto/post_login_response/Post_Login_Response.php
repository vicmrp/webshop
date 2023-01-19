<?php

namespace vezit\dto\post_login_response;

class Post_Login_Response
{
    public function __construct(
        public ?string  $email = null,
        public ?bool    $access_granted = null,
        public ?string  $message = null
    ) {}


    public function __set($name, $value)
    {
        throw new \Exception('Cant set!' . $name . ', ' . $value);
    }
}
