<?php namespace vezit\dto;
use vezit\models\session\customer\Customer;

class Session_Update_Customer_Request
{
    public function __construct(
        public ?Customer $customer = null
    ) {}
}
