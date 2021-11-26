<?php

namespace vezit\classes\login;

require __DIR__.'/../../global-requirements.php';

use vezit\classes\dto\login\response as response;

class Login implements ILogin
{
  private $username;
  private $identity;
  private $groupmember;
  

  public function __construct()
  {  }

  public function set_username($username) : void {
    $this->username = $username;
  }

  public function set_identity($identity) : void {
    $this->identity = $identity;
  }

  public function set_groupmember($groupmember) : void {
    $this->groupmember = $groupmember;
  }

  public function set_validation_result() : response\Login_Response {
    $username     = $this->username;
    $identity     = $this->identity;
    $groupmember  = $this->groupmember;

    $from_top_folder = _from_top_folder();
    $command = "bash $from_top_folder/scripts/Test-ADAuthentication.sh --Username '$username' --Identity '$identity' --GroupMember $groupmember";
    
    $login_response = new response\Login_Response();
    $login_response->username                   = $username;
    $login_response->groupmember                = $groupmember;
    $login_response->user_credentials_is_valid  = (shell_exec($command) === "True") ? true : false;
    $login_response->php_session_is_active = isset($login_response);  
    $_SESSION['login_response'] = $login_response;

    return $this->get_login_status();
  }

  public function get_login_status() : response\Login_Response {

    if(!(isset($_SESSION['login_response']))) {
      $login_response = new response\Login_Response();
      return $login_response;
    }

    return $_SESSION['login_response'];
  }

  public function set_destroy_login_session() : response\Login_Response {
    // $login_response = null;
    if(isset($_SESSION['login_response'])) {
      unset($_SESSION['login_response']);
    }   
    return $this->get_login_status();
  }

}
