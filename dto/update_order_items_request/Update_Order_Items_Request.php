<?php

namespace vezit\dto\update_order_items_request;

class Update_Order_Items_Request
{

    public function __construct(
        private ?array $products = null
    )
    { }

    public function __set($name, $value) {
        throw new \Exception('Cant set!' . $name . ', ' . $value);
    }

    public function get_products() {
        return $this->products;
    }

    public function set_products(array $array) {
        array_walk($array, function ($item) {
            if (!($item instanceof Product)) {
                throw new \Exception('Incorrect instance');
            }
        });
        $this->products = $array;
    }
}
