<?php

namespace vezit\dto\class\session\order;

require __DIR__ . '/../../../../global-requirements.php'; // __DIR__._from_top_folder().'/

use JsonSerializable;
use vezit\dto\class\session\order\order_item\Order_Item;
use vezit\dto\class\session\order\order_status\Order_Status;
use vezit\dto\class\order_item\response\Order_Item_Response;
use vezit\classes\error\Error;

class Order implements JsonSerializable
{


    public function __construct(
        public int $order_id = 0,
        private array $order_items = [],
        public Order_Status $order_status = new Order_Status,
    ) {
        array_walk($order_items, function ($order_item) {
            if (!($order_item instanceof Order_Item)) {
                throw new \Exception('Order_Items must be an instance of Order_Item');
            }
        });
    }


    public function set_order_items(array $order_items)
    {
        array_walk($order_items, function ($order_item) {
            if (!($order_item instanceof Order_Item)) {
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
