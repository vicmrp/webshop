<?php

namespace vezit\dto\session_delete_response;

class Session_Delete_Response
{
    public function __construct(
        public ?bool $session_has_been_unset = null,
        public ?string $note = null
    ) {
    }

    public function __set($name, $value)
    {
        throw new \Exception('Cant set!' . $name . ', ' . $value);
    }
}
