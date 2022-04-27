<?php

namespace vezit\entities\class\order\item;



class Item
{

    public function __construct(
        public ?int $session_order_items_pk = null,
        public ?int $order_id = null,
        public ?int $product_id = null,
        public ?string $product_name = null,
        public ?int $price = null,
        public ?int $quantity = null
    ) {}


}
