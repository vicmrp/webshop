<?php namespace vezit\entities;
require __DIR__ . '/../global-requirements.php';


class Users {

    private array $_users = [];

    public function set($users) : void {

        array_walk($users, function($user) {
            if (!($user instanceof User)) {
                throw new \Exception('must be an instance of User');
                return;
            }
        });

        $this->_users = $users;
    }



    public function get() : array {
        return $this->_users;
    }

    public function __set($name, $value)
    {
        throw new \Exception('Cant set!' . $name . ', ' . $value);
    }


    // TODO json serialize convert private property before JSON
}