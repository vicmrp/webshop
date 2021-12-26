<?php

namespace vezit\_repositories\product_repository;

interface IProduct_Repository {
  public function get_all() : array;
  public function find(string $id) : object;
  public function insert(object $product) : void;
  public function update(string $id, object $product) : void;
  public function delete(object $product) : void;
}
