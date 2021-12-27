<?php
namespace vezit\repositories\product_repository;

require __DIR__.'/../../global-requirements.php';

use vezit\entities\product as Entity;

class Product_Repository implements IProduct_Repository {

  // Create connection
  public function __construct() { 
    // -- sql -- //
    global $g_db_conn;
    $this->db_conn = new \mysqli($g_db_conn->servername, $g_db_conn->username, $g_db_conn->password, $g_db_conn->dbname);
    if ($this->db_conn->connect_error) {
      die("Connection failed: " . $this->db_conn->connect_error); // Check connection
    }
    // -- sql -- //
  }

  public function get_all() : array {
    $sql = "SELECT * FROM `Product`";
    $stmt = $this->db_conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $json = mysqli_fetch_all ($result, MYSQLI_ASSOC);
    
    return (array)$json;
  }

  public function find(int $id) : Entity\Product {
    
    $sql = "SELECT * FROM `Product` WHERE Product.Id=?";
    $stmt = $this->db_conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
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