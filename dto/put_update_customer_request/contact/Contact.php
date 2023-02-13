<?php

namespace vezit\dto\put_update_customer_request;




class Contact
{

    public function __construct(
        public ?string $email = null
    ) {
    }


    public function __set($name, $value)
    {
        throw new \Exception('Cant set!' . $name . ', ' . $value);
    }
}
