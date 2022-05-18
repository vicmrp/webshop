<?php namespace vezit\dto\endpoints\get_products\response;
use vezit\dto\internal_dtos\products\Products;

class Get_Products_Response
{
    private Products $products;

    public function get() : array {
        return $this->products->get();
    }

    public function set($products) : void {

        if ($products instanceof Products)
            $this->products = $products;
        else
            throw new \Exception("Error setting Products", 1);
    }
}
