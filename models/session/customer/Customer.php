<?php namespace vezit\models\session\customer;
use vezit\models\session\customer\address\Address;
use vezit\models\session\customer\company\Company;
use vezit\models\session\customer\contact\Contact;
require __DIR__ . '/../../../global-requirements.php';

class Customer
{

    public function __construct(
        public ?string $fullname                      = null,
        public ?bool $tos_and_tac_has_been_accepted   = null,
        public ?bool $customer_details_is_satisfied   = null,
        public Contact $contact                       = new Contact
    )
    { }

    public function __set($name, $value)
    {
        throw new \Exception('Cant set!' . $name . ', ' . $value);
    }
}
