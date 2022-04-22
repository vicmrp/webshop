<?php

namespace vezit\repositories\user_repository;

require __DIR__ . '/../../global-requirements.php';

use vezit\entities\user\User;
use vezit\classes\error\Error;
use vezit\classes\mysqli\Mysqli;


class User_Repository implements IUser_Repository
{

    public function __construct(private $_mysqli = new Mysqli)
    {}

    public function get_user_by_id(int $id): User
    {
        $sql = "SELECT * FROM `user` WHERE user.pk_user=?";
        $stmt = $this->_mysqli->get_db_conn()->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $entity = $result->fetch_assoc();

        $user = new User();
        $user->pk_user = $entity['pk_user'];
        $user->email = $entity['email'];
        $user->hashed_password = $entity['hashed_password'];

        return $user;
    }

    public function get_user_by_email(string $email): User
    {
        $sql = "SELECT * FROM `user` WHERE user.email=?";
        $stmt = $this->_mysqli->get_db_conn()->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $error_message = "get_user_by_email '$email' does not exist in database: ";
            new Error(__FILE__, $error_message, $fatal_error = true);
        }

        $entity = $result->fetch_assoc();

        $user = new User();
        $user->pk_user = $entity['pk_user'];
        $user->email = $entity['email'];
        $user->hashed_password = $entity['hashed_password'];


        return $user;
    }

    public function get_user_by_role(string $email): object
    {
        return (object)"";
    }
}

// $user_repository = new User_Repository();
// dd($user_repository->get_user_by_id(1));
