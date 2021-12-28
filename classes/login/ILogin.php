<?php
namespace vezit\classes\login;
use vezit\classes\dto\login\response as response;


interface ILogin {
  public function set_username($username) : void;
  public function set_identity($identity) : void;
  public function set_groupmember($groupmember) : void;
  public function set_validation_result() : response\Login_Response;
  public function get_login_status() : response\Login_Response;
  public function set_destroy_login_session() : response\Login_Response;
}