<?php
namespace vezit\classes\session\customer\contact;



require_once __DIR__.'/../../../../global-requirements.php'; // __DIR__._from_top_folder().'/





class Contact implements \JsonSerializable {
  private $phone;
  private $email;

  public function __construct() {

  }

  public function set_phone($phone)
  {
    $this->phone = $phone;
  }

  public function set_email($email)
  {
    $this->email = $email;
  }

  // Includes private properties in json_encode()
  public function jsonSerialize()
  {
      $vars = get_object_vars($this);

      return $vars;
  }
}