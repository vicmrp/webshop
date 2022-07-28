<?php

namespace vezit\entities;



class Session_Order_Item
{

    public function __construct(
        public  ?int $session_order_item_pk = null,
        public  ?int $session_pk_fk = null,
        public  ?int $product_pk_fk = null,
        public  ?\DateTime $datetime_created = null,
        public  ?\DateTime $datetime_last_modified = null,
        public  ?string $name = null,
        public  ?int $price = null,
        public  ?int $quantity = null
    ) {}

    public function __set($name, $value)
    {
        throw new \Exception('Cant set!' . $name . ', ' . $value);
    }
}
