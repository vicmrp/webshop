<?php namespace vezit\dto\internal_dtos\session\customer;
use vezit\dto\internal_dtos\session\customer\address\Address;
use vezit\dto\internal_dtos\session\customer\company\Company;
use vezit\dto\internal_dtos\session\customer\contact\Contact;
require __DIR__ . '/../../../../global-requirements.php';

class Customer
{

    public function __construct(
        public string $fullname = '',
        public bool $details_satisfied_for_payment = false,
        public Address $address = new Address,
        public Contact $contact = new Contact,
        public Company $company = new Company
    )
    { }
}
