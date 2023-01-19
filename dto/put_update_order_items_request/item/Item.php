<?php

namespace vezit\dto\put_update_order_items_request;


class Item
{


    public function __construct(
        public int $product_pk = -1,
        public int $quantity = -1
    )
    {
    }
    public function __set($name, $value) : void {
        throw new \Exception('Cant set!' . $name . ', ' . $value);
    }
}
