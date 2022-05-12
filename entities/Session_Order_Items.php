<?php namespace vezit\entities;
require __DIR__ . '/../global-requirements.php';


class Session_Order_Items {

    private array $session_order_items = [];

    public function set_session_order_items($session_order_items) : void {

        array_walk($session_order_items, function($session_order_item) {
            if (!($session_order_item instanceof Session_Order_Item)) {
                throw new \Exception('must be an instance of Session');
                return;
            }
        });

        $this->session_order_items = $session_order_items;
    }

    public function get_session_order_items() : array {
        return $this->session_order_items;
    }
}