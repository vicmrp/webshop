<?php namespace vezit\entities;
require __DIR__ . '/../global-requirements.php';


class Sessions {

    private array $sessions = [];

    public function set($sessions) : void {

        array_walk($sessions, function($session) {
            if (!($session instanceof Session)) {
                throw new \Exception('must be an instance of Session');
                return;
            }
        });

        $this->sessions = $sessions;
    }

    public function get() : array {
        return $this->sessions;
    }


    public function __set($name, $value)
    {
        throw new \Exception('Cant set!' . $name . ', ' . $value);
    }
}