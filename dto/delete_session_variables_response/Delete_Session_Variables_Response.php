<?php

namespace vezit\dto\delete_session_variables_response;

class Delete_Session_Variables_Response
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
