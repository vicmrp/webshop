<?php

namespace vezit\dto\internal_dtos\session\order\item;



class Item
{

    public function __construct(
        public ?int      $id        = null,
        public ?string   $name      = null,
        public ?int      $price     = null,
        public ?int      $quantity  = null
    ) {}


}
