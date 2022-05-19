<?php namespace vezit\dto\internal_dtos\product;

require __DIR__ . '/../../../global-requirements.php';

class Product implements \JsonSerializable
{
    public function __construct(
        public ?int         $product_pk                 = null,
        public ?\DateTime   $datetime_created           = null,
        public ?\DateTime   $datetime_last_modified     = null,
        public ?string      $name                       = null,
        public ?int         $price                      = null,
        public ?int         $quantity                   = null
    )
    {}

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);

        return $vars;
    }
}
