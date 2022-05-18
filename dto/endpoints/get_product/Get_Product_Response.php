<?php namespace vezit\dto\endpoints\get_product\response;
use vezit\dto\internal_dtos\product\Product;
class Get_Product_Response
{
    public function __construct(public Product $product = new Product()) {}
}
