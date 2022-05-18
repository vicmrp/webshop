<?php namespace vezit\dto\internal_dtos\products;
use vezit\dto\internal_dtos\product\Product;

require __DIR__ . '/../../../global-requirements.php';


class Products {

    private array $products = [];

    public function set($products) : void {

        array_walk($products, function($product) {
            if (!($product instanceof Product)) {
                throw new \Exception('must be an instance of Product');
                return;
            }
        });

        $this->products = $products;
    }

    public function get() : array {
        return $this->products;
    }
}