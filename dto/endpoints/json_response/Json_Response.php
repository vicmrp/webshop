<?php namespace vezit\dto\endpoints\json_response;

use stdClass;

class Json_Response implements \JsonSerializable
{
    public function __construct(public $object_to_serialize = null) {}

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        return $vars;
    }
}
