<?php

namespace vezit\dto\get_all_products_response;

class Product
{

    public function __construct(
        public ?int     $product_pk                     = null,
        public ?string  $name                           = null,
        public ?int     $price                          = null,
        public ?int     $company                        = null
    )
    { }

    public function __set($name, $value) {
        throw new \Exception('Cant set!' . $name . ', ' . $value);
    }
}

