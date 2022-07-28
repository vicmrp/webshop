<?php

namespace vezit\dto\update_customer_request;




class Contact
{

    public function __construct(
        public ?string $phone = null,
        public ?string $email = null
    ) {
    }


    public function __set($name, $value)
    {
        throw new \Exception('Cant set!' . $name . ', ' . $value);
    }
}
