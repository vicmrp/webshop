<?php

namespace vezit\dto\endpoints\unset_session\response;

class Unset_Session_Response
{
    public function __construct(
        public ?bool $session_has_been_unset = null,
        public ?string $note = null
    ) {}
}