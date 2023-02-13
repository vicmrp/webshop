<?php

namespace vezit\repositories\user_repository;

require __DIR__ . '/../../global-requirements.php';

use vezit\entities\User;
use vezit\entities\Users;
use vezit\classes\error\Error;
use vezit\repositories\super_repository\Super_Repository;


class User_Repository
{
    private static $_times_instantiated = 0;
    private static $_times_destroyed = 0;
    private static $_instance = null;


    public static function get_instance(Super_Repository $super_repository = null)
    {
        return (null === self::$_instance) ? new User_Repository(

            (null === $super_repository) ? Super_Repository::get_instance() : $super_repository

        ) : self::$_instance;
    }

    public static function destroy_instance() : void {
        if (null !== self::$_instance) {
            self::$_times_destroyed++;
            self::$_instance = null;
        }
    }

    private function __construct(private Super_Repository $_super_repository)
    {
        self::$_times_instantiated++;
    }


    public function insert(User $user) : bool {
        return $this->_insert($user);
    }

    public function update(string $email, User $user) : bool {
        return $this->_update($email, $user);
    }

    public function get_all(): Users {
        return $this->_get_all_from__user_table();
    }

    private function _get_all_from__user_table(): Users {

        $users = new Users;
        (array)$array_of_users = [];

        $entities = $this->_super_repository->get_all("user");

        // TODO array map
        foreach ($entities as $entity) {
            $array_of_users += [$entity['email'] => $this->_construct_user_entity($entity)];
        }

        $users->set($array_of_users);

        return $users;
    }


    private function _insert(User $user) : bool {
        $FIELDS_TO_IGNORE = ['user_pk', 'datetime_created', 'datetime_last_modified'];
        return $this->_super_repository->insert_entity($user, 'user', $FIELDS_TO_IGNORE);
    }

    private function _update(string $email, User $user) : bool {
        $FIELDS_TO_IGNORE = ['user_pk', 'datetime_created', 'datetime_last_modified'];
        return $this->_super_repository->update_entity(
            $object_be_updated = $user,
            $table = 'user',
            $where_clause = 'email',
            $identifier = $email,
            $fields_to_ignore = $FIELDS_TO_IGNORE
        );
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
