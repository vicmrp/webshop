<?php
namespace vezit\_repositories\product_repository;

require __DIR__.'/../../global-requirements.php';

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