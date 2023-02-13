<?php

namespace vezit\repositories\product_repository;

require __DIR__ . '/../../global-requirements.php';


use vezit\entities\Product;
use vezit\classes\error as Error;
use vezit\classes\mysqli\Mysqli;
use vezit\repositories\super_repository\Super_Repository;
use vezit\entities\Products;

class Product_Repository
{
    private static $_times_instantiated = 0;
    private static $_instance = null;

    public static function get_instance(Super_Repository $super_repository = null)
    {
        return (null === self::$_instance) ? new Product_Repository(

            (null === $super_repository) ? Super_Repository::get_instance() : $super_repository

        ) : self::$_instance;
    }

    // Create connection
    private function __construct(
        private Super_Repository $_super_repository
    ) {
        self::$_times_instantiated++;
    }

    public function get_all(): Products
    {
        $products = $this->_get_all_from__product_table();
        return $products;
    }

    public function get_by_pk(int $pk): Product
    {
        return $this->_get_one_entity_from__product_table($pk);
    }

    public function update(int $pk, Product $product): bool
    {
        return $this->_update__product_table($pk, $product);
    }

    private function _update__product_table(int $pk, Product $product)
    {
        $fields_to_ignore = ['product_pk', 'datetime_created', 'datetime_last_modified'];
        return $this->_super_repository
            ->update_entity(
                $object_be_updated = $product,
                $table = 'product',
                $where_clause = 'product_pk',
                $identifier = $pk,
                $fields_to_ignore
            );
    }

    private function _get_all_from__product_table(): Products
    {

        $products = new Products;
        (array)$array_of_products = [];

        $entities = $this->_super_repository->get_all("product");

        foreach ($entities as $entity) {
            $array_of_products += [$entity['product_pk'] => $this->_construct_product_entity($entity)];
        }

        $products->set($array_of_products);

        return $products;
    }


    private function _get_one_entity_from__product_table(int $pk): Product
    {

        $entities = $this->_super_repository
            ->get_all_by_where_clause($table = 'product', $where_clause = 'product_pk', $identifier = $pk);

        if (1 > count($entities))
            throw new \Exception("zero entities returned. Expected one", 1);


        $entity = $entities[0];
        return $this->_construct_product_entity($entity);
    }


    private function _construct_product_entity(array $entity): Product
    {
        return new Product(
            $entity['product_pk'],
            new \DateTime($entity['datetime_created']),
            new \DateTime($entity['datetime_last_modified']),
            $entity['name'],
            $entity['price'],
            $entity['quantity']
        );
    }
}
