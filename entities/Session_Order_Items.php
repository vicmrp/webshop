<?php namespace vezit\entities;
require __DIR__ . '/../global-requirements.php';


class Session_Order_Items {
    private array $items = [];

    public function set(array $items) : void {

        array_walk($items, function($item) {
            if (!($item instanceof Session_Order_Item)) {
                throw new \Exception('must be correct instance');
                return;
            }
        });

        $this->items = $items;
    }

    public function get() : array {
        return $this->items;
    }

    public function __set($name, $value)
    {
        throw new \Exception('Cant set!' . $name . ', ' . $value);
    }
}