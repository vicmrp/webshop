<?php namespace vezit\dto;


class Session_Order_Update_Request
{
    public function __construct(
        public ?int $product_pk = null,
        public ?int $quantity = null

    ) {}
}
