<?php
namespace vezit\_services\login_service;

use vezit\_repositories\user as User;
use vezit\_dto\user\resquest as Request;
use vezit\_dto\user\response as Response;

interface ILogin_Service {

  public function validate_user_credentials(Request\Login_Request $login_request) : Response\Login_Response;

}