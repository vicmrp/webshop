<?php
require __DIR__ . '/../../../global-requirements.php';
header('Content-Type: application/json; charset=utf-8');

use vezit\classes\controller\product_controller\Product_Controller;

$controller = new Product_Controller($_SERVER['REQUEST_METHOD']);
(string)$result_in_json = $controller->get_json_response();

echo $result_in_json;
