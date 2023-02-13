<?php

namespace vezit\dto\put_update_user_response;

class Put_Update_User_Response
{
    public function __construct(
        public ?bool   $password_has_been_updated = null,
        public ?string $message             = null

    ) {
    }

    public function __set($name, $value)
    {
        throw new \Exception('Cant set!' . $name . ', ' . $value);
    }
}
