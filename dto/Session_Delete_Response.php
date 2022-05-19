<?php

namespace vezit\dto;

class Session_Delete_Response
{
    public function __construct(
        public ?bool $session_has_been_unset = null,
        public ?string $note = null
    ) {}
}