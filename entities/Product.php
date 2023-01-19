<?php namespace vezit\entities;

class Product
{
    public function __construct(
        public ?int         $product_pk                 = null,
        public ?\DateTime   $datetime_created           = null,
        public ?\DateTime   $datetime_last_modified     = null,
        public ?string      $name                       = null,
        public ?int         $price                      = null,
        public ?int         $quantity                   = null
    ) {}

    public function __set($name, $value)
    {
        throw new \Exception('Cant set!' . $name . ', ' . $value);
    }
}
