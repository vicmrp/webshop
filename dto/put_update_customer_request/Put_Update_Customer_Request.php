<?php namespace vezit\dto\put_update_customer_request;

require __DIR__ . '/../../global-requirements.php';

class Put_Update_Customer_Request
{

    public function __construct(
        public ?string $fullname                    = null,
        public ?bool $tos_and_tac_has_been_accepted = null,
        public Contact $contact                     = new Contact
    )
    { }

    public function __set($name, $value) {
        throw new \Exception('Cant set!' . $name . ', ' . $value);
    }
}
