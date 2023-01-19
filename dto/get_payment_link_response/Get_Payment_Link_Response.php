<?php namespace vezit\dto\get_payment_link_response;

class Get_Payment_Link_Response
{
    public function __construct(
        public ?string $payment_link    =  null,
        public ?string $note            = null
    ) {}


    public function __set($name, $value)
    {
        throw new \Exception('Cant set!' . $name . ', ' . $value);
    }
}
