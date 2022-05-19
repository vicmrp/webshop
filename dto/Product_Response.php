<?php namespace vezit\dto;

class Product_Response
{
    public function __construct(
        public ?int         $product_pk                 = null,
        public ?string      $name                       = null,
        public ?int         $price                      = null,
        public ?int         $quantity                   = null
    )
    {}

}
