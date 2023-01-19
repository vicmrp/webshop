<?php

namespace vezit\dto\put_update_user_request;

class Put_Update_User_Request
{
    public function __construct(
        // public ?string $email           = null, Requires login
        public ?string $new_password    = null
    ) {
    }

    public function __set($name, $value)
    {
        throw new \Exception('Cant set!' . $name . ', ' . $value);
    }
}
