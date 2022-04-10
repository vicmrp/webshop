<?php
namespace vezit\repositories\product_repository;

require_once __DIR__.'/../../global-requirements.php';

use vezit\entities\product as Entity;
use vezit\classes\error as Error;
use vezit\entities\product\Products;

class Product_Repository implements IProduct_Repository {

  // Create connection
  public function __construct() { 
    // -- sql -- //
    global $g_db_conn;
    $this->db_conn = new \mysqli($g_db_conn->servername, $g_db_conn->username, $g_db_conn->password, $g_db_conn->dbname);
    if ($this->db_conn->connect_error) {
      $error_message = "Connection failed: " . $this->db_conn->connect_error;
      new Error\Error(__FILE__, $error_message, $fatal_error=true);
    }
    // -- sql -- //
  }

  public function get_all() : Entity\Products {
    $sql = "SELECT * FROM `Product`";
    $stmt = $this->db_conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $enitities = mysqli_fetch_all ($result, MYSQLI_ASSOC);
    
    $products = new Entity\Products();
    foreach ($enitities as $key => $entity) {
      $product = new Entity\Product();
      $product->id = $entity['Id'];
      $product->name = $entity['Name'];
      $product->price = $entity['Price'];
      $product->quantity = $entity['Quantity'];
      $product->category_id = $entity['CategoryId'];
      array_push($products->list_of_products, $product);
    }

    return $products;
  }

  public function find(int $id) : Entity\Product {
    
    $sql = "SELECT * FROM `Product` WHERE Product.Id=?";
    $stmt = $this->db_conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows === 0) {
      $error_message = "Id does not exist: " . $this->db_conn->connect_error;
      new Error\Error(__FILE__, $error_message, $fatal_error=true);
    }
    
    $entity = $result->fetch_assoc();
    $response = new Entity\Product();
    $response->id = $entity['Id'];
    $response->name = $entity['Name'];
    $response->price = $entity['Price'];
    $response->quantity = $entity['Quantity'];
    $response->category_id = $entity['CategoryId'];

    return $response;
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