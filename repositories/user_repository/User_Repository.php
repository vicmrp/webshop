<?php

namespace vezit\repositories\user_repository;

require __DIR__ . '/../../global-requirements.php';

use vezit\entities\User;
use vezit\entities\Users;
use vezit\classes\error\Error;
use vezit\repositories\super_repository\Super_Repository;


class User_Repository
{

    public function __construct(
        private Super_Repository $_super_repository = new Super_Repository
        ) {}

    public function get_all(): Users {
        return $this->_get_all_from__user_table();
    }


    private function _get_all_from__user_table(): Users {

        $users = new Users;
        (array)$array_of_users = [];

        $entities = $this->_super_repository->get_all("user");

        foreach ($entities as $entity) {
            $array_of_users += [$entity['user_pk'] => $this->_construct_user_entity($entity)];
        }

        $users->set($array_of_users);

        return $users;
    }


    private function _construct_user_entity(array $entity) : User {
        return new User (
            $entity['user_pk'],
            new \DateTime($entity['datetime_created']),
            new \DateTime($entity['datetime_last_modified']),
            $entity['email'],
            $entity['hashed_password']
        );
    }
}

// $user_repository = new User_Repository();
// dd($user_repository->get_user_by_id(1));
