<?php namespace vezit\models\payment_link_response;

class Payment_Link_Response
{
    public function __construct(
        public ?string $url = null
    ) {}


    public function __set($name, $value)
    {
        throw new \Exception('Cant set!' . $name . ', ' . $value);
    }
}
