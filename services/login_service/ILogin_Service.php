<?php
namespace vezit\services\login_service;

use vezit\dto\login\request\Login_Request;
use vezit\dto\login\response\Login_Response;

interface ILogin_Service {

  public function validate_user_credentials(Login_Request $login_request) : Login_Response;

}