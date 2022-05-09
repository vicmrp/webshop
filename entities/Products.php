<?php namespace vezit\entities;
require __DIR__ . '/../global-requirements.php';


class Products {

    private array $products = [];

    public function set_products($products) : void {

        array_walk($products, function($product) {
            if (!($product instanceof Product)) {
                throw new \Exception('must be an instance of Product');
                return;
            }
        });

        $this->products = $products;
    }

    public function get_products() : array {
        return $this->products;
    }
}