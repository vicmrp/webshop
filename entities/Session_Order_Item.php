<?php

namespace vezit\entities;



class Session_Order_Item
{

    public function __construct(
        public  ?int $session_order_item_pk = null,
        private int $order_id,
        public  int $product_id,
        public  string $product_name,
        public  int $price,
        public  int $quantity
    ) {}


}
