<?php

namespace vezit\classes\services\product;

interface IProduct {
  public function find(string $id) : object;
  public function insert(object $product) : void;
  public function update(string $id, object $product) : void;
  public function delete(object $product) : void;
}
