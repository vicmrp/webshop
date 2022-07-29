<?php

namespace vezit\dto\session_order_update_request;


class Session_Order_Update_Request
{
    public function __construct(
        public ?int $product_pk = null,
        public ?int $quantity = null
    ) {
    }


    public function __set($name, $value)
    {
        throw new \Exception('Cant set!' . $name . ', ' . $value);
    }
}
