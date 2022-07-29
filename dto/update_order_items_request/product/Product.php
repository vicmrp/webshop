<?php

namespace vezit\dto\update_order_items_request;


class Product
{

    public function __construct(
        public ?int     $product_pk                     = null,
        public ?int     $quantity                       = null
    )
    { }

    public function __set($name, $value) {
        throw new \Exception('Cant set!' . $name . ', ' . $value);
    }
}