<?php

namespace vezit\dto\class\session\customer;



require __DIR__ . '/../../../../global-requirements.php'; // __DIR__._from_top_folder().'/

use vezit\dto\class\session\customer\address\Address;
use vezit\dto\class\session\customer\contact\Contact;
use vezit\dto\class\session\customer\company\Company;




class Customer
{

    public function __construct(
        public string $fullname = '',
        public bool $customer_details_satisfied_for_payment = false,
        public Address $address = new Address,
        public Contact $contact = new Contact,
        public Company $company = new Company
    )
    { }
}
