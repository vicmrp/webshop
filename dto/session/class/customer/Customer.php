<?php

namespace vezit\dto\class\session\customer;



require __DIR__ . '/../../../../global-requirements.php'; // __DIR__._from_top_folder().'/

use vezit\dto\class\session\customer\address\Address;
use vezit\dto\class\session\customer\contact\Contact;
use vezit\dto\class\session\customer\company\Company;




class Customer
{

    public function __construct(
        public string $fullname,
        public bool $customer_details_satisfied_for_payment,
        public Address $address,
        public Contact $contact,
        public Company $company
    )
    { }
}
