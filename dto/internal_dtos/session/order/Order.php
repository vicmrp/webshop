<?php namespace vezit\dto\internal_dtos\session\order;
use vezit\dto\internal_dtos\session\order\status\Status;
use vezit\dto\internal_dtos\session\order\item\Item;
use JsonSerializable;
require __DIR__ . '/../../../../global-requirements.php'; // __DIR__.g_from_top_folder().'/

class Order implements JsonSerializable
{


    private function _ensure_all_items_are_valid_before_applying(array $items) : bool
    {
        array_walk($items, function (&$item) {
            if (!($item instanceof Item)) {
                throw new \Exception('Element in Order_Items must be an instance of Order_Item');
                return false;
            }

            if ($item === null) {
                throw new \Exception('Element in Order_Items cannot be null');
                return false;
            }
        });
        return true;
    }




    public function __construct(
        public int $id = 0,
        $items = [],
        public Status $status = new Status,
    )
    {
        if($this->_ensure_all_items_are_valid_before_applying($this->items))
        {
            $this->items = $items;
        }
    }


    public function set_order_items(array $items)
    {
        if($this->_ensure_all_items_are_valid_before_applying($this->items))
        {
            $this->items = $items;
        }
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
