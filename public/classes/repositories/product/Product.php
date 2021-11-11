<?php
namespace vezit\classes\repositories\product;

require __DIR__.'/../../../global-requirements.php';

class Product implements IProduct {

  public function find(string $id) : object
  {
    return json_decode(file_get_contents(_from_top_folder()."/temp_database/product/$id.json"));
  }

  public function insert(object $product) : void
  {
    
  }
  
  public function update(string $id, object $product) : void
  {
    
  }

  public function delete(object $product) : void
  {
    
  }

}