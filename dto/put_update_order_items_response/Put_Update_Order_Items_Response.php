<?php

namespace vezit\dto\put_update_order_items_response;

use JsonSerializable;
use vezit\models\session\order\item\Item;

class Put_Update_Order_Items_Response implements JsonSerializable
{

    private array $_items = [];

    public function __set($name, $value) {
        throw new \Exception('Cant set!' . $name . ', ' . $value);
    }

    public function get_items() : array {
        return $this->_items;
    }

    public function set_items(array $array) : void {
        array_walk($array, function ($element) {
            if (!($element instanceof Item)) {
                throw new \Exception('Incorrect instance');
            }
        });
        $this->_items = $array;
    }


    public function jsonSerialize() : mixed
    {
        return get_object_vars($this);
    }


}
