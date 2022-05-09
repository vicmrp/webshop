<?php

namespace vezit\repositories\product_repository;

require __DIR__ . '/../../global-requirements.php';


use vezit\entities\Product;
use vezit\classes\error as Error;
use vezit\classes\mysqli\Mysqli;
use vezit\repositories\super_repository\Super_Repository;
use vezit\entities\Products;

class Product_Repository implements IProduct_Repository
{

    // Create connection
    public function __construct(
        private $_super_repository = new Super_Repository
        )
    {}

    public function get_all(): Products {
        $products = $this->_get_all_from_product_table();
        return $products;
    }

    public function get_by_pk(int $product_pk) : Product {

        $product = $this->_get_one_entity_from_product_table($product_pk);
        return $product;
    }

    public function insert(object $product): void
    {
    }

    public function update(int $product_pk, Product $product): void
    {
        $this->_super_repository
            ->update_entity(
                $object_be_updated = $product,
                $table = 'product',
                $where_clause = 'product_pk',
                $identifier=$product_pk);
    }

    public function delete(int $product_pk): void
    {

    }

    private function _get_all_from_product_table(): Products {

        $products = new Products;
        (array)$array_of_products = [];

        $enitities = $this->_super_repository->get_all("product");

        foreach ($enitities as $entity) {
            $array_of_products += [$entity['product_pk'] => $this->_set_product($entity)];

        }

        $products->set_products($array_of_products);

        return $products;
    }


    private function _get_one_entity_from_product_table(int $product_pk) : Product {

        $entity = $this->_super_repository
            ->get_one_entity($table="product", $where_clause="product_pk", $identifier=$product_pk);

        $product = $this->_set_product($entity);


        return $product;
    }

    private function _delete_from_product_table(int $product_pk) : void {

    }

    private function _set_product(array $entity): Product
    {
        return new Product(
            $entity['product_pk'],
            $entity['name'],
            $entity['price'],
            $entity['quantity']
        );
    }
}
