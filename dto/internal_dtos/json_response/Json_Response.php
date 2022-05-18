<?php namespace vezit\dto\internal_dtos\json_response;

use stdClass;

class Json_Response
{
    public function __construct(public object $object_to_serialize = new stdClass) {}
}
