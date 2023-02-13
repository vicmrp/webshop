<?php

namespace vezit\entities;

class User {
    public function __construct(
        public    ?int            $user_pk                  = null,
        public    ?\DateTime      $datetime_created         = null,
        public    ?\DateTime      $datetime_last_modified   = null,
        public    ?string         $email                    = null,
        public    ?string         $hashed_password          = null
    ) {}


    public function __set($name, $value)
    {
        throw new \Exception('Cant set!' . $name . ', ' . $value);
    }
}
