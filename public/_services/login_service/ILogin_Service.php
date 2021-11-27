<?php

interface ILogin_Service {

  public function validate_user_credentials(object $login_request) : object;

}