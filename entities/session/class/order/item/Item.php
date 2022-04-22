<?php

namespace vezit\entities\class\order\item;



class Item
{

    public function __construct(
        public int $id = 0,
        public string $name = '',
        public int $price = 0,
        public int $quantity = 0
    ) {}


}
