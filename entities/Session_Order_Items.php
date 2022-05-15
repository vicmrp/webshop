<?php namespace vezit\entities;
require __DIR__ . '/../global-requirements.php';


class Session_Order_Items {

    private array $session_order_items = [];

    public function set(array $session_order_items) : void {

        array_walk($session_order_items, function($session_order_item) {
            if (!($session_order_item instanceof Session_Order_Item)) {
                throw new \Exception('must be an instance of Session');
                return;
            }
        });

        $this->session_order_items = $session_order_items;
    }

    public function get() : array {
        return $this->session_order_items;
    }

    public function __set($name, $value) {
        throw new \Exception("Cannot add new property \$$name to instance of " . __CLASS__);
    }
}