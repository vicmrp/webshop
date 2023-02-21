<?php namespace vezit\entities;
require __DIR__ . '/../global-requirements.php';


class Orders {

    private array $orders = [];

    public function set($orders) : void {

        array_walk($orders, function($order) {
            if (!($order instanceof Order)) {
                throw new \Exception('must be an instance of Order');
                return;
            }
        });

        $this->orders = $orders;
    }

    public function get() : array {
        return $this->orders;
    }

    public function __set($name, $value)
    {
        throw new \Exception('Cant set!' . $name . ', ' . $value);
    }
}