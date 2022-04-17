<?php

namespace vezit\dto\class\session\order\order_item;



class Order_Item
{

    public function __construct(
        public string $product_name,
        public int $product_id,
        public int $price,
        public int $quantity
    ) {}


}
