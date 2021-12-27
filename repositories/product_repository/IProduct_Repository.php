<?php

namespace vezit\repositories\product_repository;
use vezit\entities\product as Product;

interface IProduct_Repository {
  public function get_all() : array;
  public function find(int $id) : Product\Product;
  public function insert(object $product) : void;
  public function update(string $id, object $product) : void;
  public function delete(object $product) : void;
}
