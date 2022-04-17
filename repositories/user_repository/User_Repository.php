<?php

namespace vezit\repositories\user_repository;

require __DIR__ . '/../../global-requirements.php';

use vezit\entities\user\User;
use vezit\classes\error\Error;
use vezit\classes\mysqli\Mysqli;


class User_Repository implements IUser_Repository
{

    private $mysqli = null;

    public function __construct()
    {
        $this->mysqli = new Mysqli;
    }

    public function get_user_by_id(int $id): User
    {
        $sql = "SELECT * FROM `User` WHERE User.Id=?";
        $stmt = $this->mysqli->get_db_conn()->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $entity = $result->fetch_assoc();

        $user = new User();
        $user->id = $entity['Id'];
        $user->email = $entity['Email'];
        $user->hash = $entity['Hash'];
        $user->role = $entity['Role'];

        return $user;
    }

    public function get_user_by_email(string $email): User
    {
        $sql = "SELECT * FROM `User` WHERE User.Email=?";
        $stmt = $this->mysqli->get_db_conn()->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $error_message = "get_user_by_email '$email' does not exist in database: ";
            new Error(__FILE__, $error_message, $fatal_error = true);
        }

        $entity = $result->fetch_assoc();

        $user = new User();
        $user->id = $entity['Id'];
        $user->email = $entity['Email'];
        $user->hash = $entity['Hash'];
        $user->role = $entity['Role'];

        return $user;
    }

    public function get_user_by_role(string $email): object
    {
        return (object)"";
    }
}

// $user_repository = new User_Repository();
// dd($user_repository->get_user_by_id(1));
