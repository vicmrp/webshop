<?php namespace vezit\models\session\customer;
use vezit\models\session\customer\address\Address;
use vezit\models\session\customer\company\Company;
use vezit\models\session\customer\contact\Contact;
require __DIR__ . '/../../../global-requirements.php';

class Customer
{

    public function __construct(
        public ?string $fullname                      = null,
        public ?bool $details_satisfied_for_shipment  = null,
        public ?bool $has_at_least_one_item_in_basket = null,
        public Address $address                       = new Address,
        public Contact $contact                       = new Contact,
        public Company $company                       = new Company
    )
    { }

    public function __set($name, $value)
    {
        throw new \Exception('Cant set!' . $name . ', ' . $value);
    }
}
