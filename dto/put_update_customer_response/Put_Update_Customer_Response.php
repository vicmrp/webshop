<?php

namespace vezit\dto\put_update_customer_response;

use JsonSerializable;
use vezit\models\session\customer\Customer;

class Put_Update_Customer_Response implements JsonSerializable
{


    public function __construct(public ?Customer $customer = null) {

    }

    public function __set($name, $value) {
        throw new \Exception('Cant set!' . $name . ', ' . $value);
    }

    public function jsonSerialize() : mixed
    {
        return get_object_vars($this);
    }

}
