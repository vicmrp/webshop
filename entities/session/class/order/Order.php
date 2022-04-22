<?php

namespace vezit\entities\class\order;

require __DIR__ . '/../../../../global-requirements.php'; // __DIR__._from_top_folder().'/

use JsonSerializable;
use vezit\entities\class\order\item\Item;
use vezit\entities\class\order\status\Status;
use vezit\dto\class\order_item\response\Item_Response;
use vezit\classes\error\Error;

class Order implements JsonSerializable
{


    public function __construct(
        public int $order_id = 0,
        private array $order_items = [],
        public Status $order_status = new Status,
    ) {
        array_walk($order_items, function ($order_item) {
            if (!($order_item instanceof Item)) {
                throw new \Exception('Order_Items must be an instance of Order_Item');
            }
        });
    }


    public function set_order_items(array $order_items)
    {
        array_walk($order_items, function ($order_item) {
            if (!($order_item instanceof Item)) {
                throw new \Exception('Order_Items must be an instance of Order_Item');
            }
        });
        $this->order_items = $order_items;
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
