<?php
namespace vezit\dto\class\session\customer\contact;



require __DIR__.'/../../../../../global-requirements.php';





class Contact {

  public function __construct(
    public string $phone,
    public string $email
  ) {}

}