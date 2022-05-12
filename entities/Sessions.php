<?php namespace vezit\entities;
require __DIR__ . '/../global-requirements.php';


class Sessions {

    private array $sessions = [];

    public function set_sessions($sessions) : void {

        array_walk($sessions, function($session) {
            if (!($session instanceof Session)) {
                throw new \Exception('must be an instance of Session');
                return;
            }
        });

        $this->sessions = $sessions;
    }

    public function get_sessions() : array {
        return $this->sessions;
    }
}