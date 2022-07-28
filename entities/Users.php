<?php namespace vezit\entities;
require __DIR__ . '/../global-requirements.php';


class Users {

    private array $users = [];

    public function set($users) : void {

        array_walk($users, function($user) {
            if (!($user instanceof User)) {
                throw new \Exception('must be an instance of User');
                return;
            }
        });

        $this->users = $users;
    }

    public function get() : array {
        return $this->users;
    }

    public function __set($name, $value)
    {
        throw new \Exception('Cant set!' . $name . ', ' . $value);
    }
}