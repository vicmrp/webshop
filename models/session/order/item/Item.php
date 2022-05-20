<?php

namespace vezit\models\session\order\item;



class Item
{

    public function __construct(
        public  ?int $product_pk_fk = null,
        public  ?string $name = null,
        public  ?int $price = null,
        public  ?int $quantity = null
    ) {}


}
