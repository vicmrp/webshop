<?php namespace vezit\models\session\order;
use vezit\models\session\order\status\Status;
use vezit\models\session\order\item\Item;
use JsonSerializable;
require __DIR__ . '/../../../global-requirements.php'; // __DIR__.g_from_top_folder().'/

class Order implements JsonSerializable
{
    // private $items = array();






    public function __construct(
        public  ?string $id = null,
        private ?array $items = null,
        public  Status $status = new Status,
    )
    {
        if($this->_ensure_all_items_are_valid_before_applying($items))
        {
            $this->items = $items;
        }
    }


    public function set_items(array $items) {
        if($this->_ensure_all_items_are_valid_before_applying($items)) $this->items = $items;
    }


    public function get_items() {
        return $this->items;
    }




    private function _ensure_all_items_are_valid_before_applying(array $items) : bool {
        array_walk($items, function ($item) {
            if (!($item instanceof Item)) {
                throw new \Exception('Element in Order_Items must be an instance of Order_Item not ' . gettype($item));
                return false;
            }
        });
        return true;
    }

    public function jsonSerialize() : mixed
    {
        $vars = get_object_vars($this);
        return $vars;
    }

    public function __set($name, $value)
    {
        throw new \Exception('Cant set!' . $name . ', ' . $value);
    }
}
