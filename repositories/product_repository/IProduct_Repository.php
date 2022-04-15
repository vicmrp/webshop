<?php

namespace vezit\repositories\product_repository;
use vezit\entities\product as Entity;

interface IProduct_Repository {
  public function get_all() : Entity\Products;
  public function find(int $id) : Entity\Product;
  public function insert(object $product) : void;
  public function update(string $id, object $product) : void;
  public function delete(object $product) : void;
}
