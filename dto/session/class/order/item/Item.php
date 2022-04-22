<?php

namespace vezit\dto\class\session\order\item;



class Item
{

    public function __construct(
        public int $id,
        public string $name,
        public int $price,
        public int $quantity
    ) {}


}
