<?php
namespace vezit\dto\internal_dtos\session\customer\contact;




class Contact {

  public function __construct(
    public string $phone = '',
    public string $email = ''
  ) {}

}