<?php

namespace vezit\entities;



class Session_Order_Item
{

    public function __construct(
        public  ?int $session_order_item_pk = null,
        public  ?int $session_pk_fk = null,
        public  ?int $product_pk_fk = null,
        public  ?string $name = null,
        public  ?int $price = null,
        public  ?int $quantity = null
    ) {}


}
