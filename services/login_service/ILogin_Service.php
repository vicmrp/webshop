<?php
namespace vezit\services\login_service;

use vezit\dto\login\resquest as Login_Request;
use vezit\dto\login\response as Login_Response;

interface ILogin_Service {

  public function validate_user_credentials(Login_Request\Login_Request $login_request) : Login_Response\Login_Response;

}