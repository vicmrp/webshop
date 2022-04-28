<?php

namespace vezit\entities;



class Session_Order_Item
{

    public function __construct(
        public ?int $session_order_items_pk = null,
        public int $order_id,
        public int $product_id,
        public string $product_name,
        public int $price,
        public int $quantity
    ) {}


}
