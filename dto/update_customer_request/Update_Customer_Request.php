<?php namespace vezit\dto\update_customer_request;

require __DIR__ . '/../../global-requirements.php';

class Update_Customer_Request
{

    public function __construct(
        public ?string $fullname                    = null,
        public Address $address                     = new Address,
        public Contact $contact                     = new Contact,
        public Company $company                     = new Company
    )
    { }

    public function __set($name, $value) {
        throw new \Exception('Cant set!' . $name . ', ' . $value);
    }
}
