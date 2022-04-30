<?php

namespace vezit\dto\class\session\order;

require __DIR__ . '/../../../../global-requirements.php'; // __DIR__.g_from_top_folder().'/

use JsonSerializable;
use vezit\dto\class\session\order\item\Item;
use vezit\dto\class\session\order\status\Status;
use vezit\dto\class\item\response\Item_Response;
use vezit\classes\error\Error;

class Order implements JsonSerializable
{


    public function __construct(
        public int $id = 0,
        private array $items = [],
        public Status $status = new Status,
    ) {
        array_walk($items, function ($item) {
            if (!($item instanceof Item)) {
                throw new \Exception('Order_Items must be an instance of Order_Item');
            }
        });
    }


    public function set_order_items(array $items)
    {
        array_walk($items, function ($item) {
            if (!($item instanceof Item)) {
                throw new \Exception('Order_Items must be an instance of Order_Item');
            }
        });
        $this->items = $items;
    }

    public function get_order_items()
    {
        return $this->order_items;
    }


    public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        return $vars;
    }
}
