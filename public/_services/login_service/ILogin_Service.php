<?php
namespace vezit\_services\login_service;

use vezit\_dto\login\resquest as Login_Request;
use vezit\_dto\login\response as Login_Response;

interface ILogin_Service {

  public function validate_user_credentials(Login_Request\Login_Request $login_request) : Login_Response\Login_Response;

}