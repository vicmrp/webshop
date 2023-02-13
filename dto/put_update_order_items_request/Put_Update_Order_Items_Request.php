<?php

namespace vezit\dto\put_update_order_items_request;

class Put_Update_Order_Items_Request
{

    private array $items = [];

    public function __set($name, $value) {
        throw new \Exception('Cant set!' . $name . ', ' . $value);
    }

    public function get_items() {
        return $this->items;
    }

    public function set_items(array $array) {
        array_walk($array, function ($element) {
            if (!($element instanceof Item)) {
                throw new \Exception('Incorrect instance');
            }
        });
        $this->items = $array;
    }
}
