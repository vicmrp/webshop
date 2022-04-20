<?php
namespace vezit\dto\class\session\customer\company;

class Company
{
  public function __construct(
      public string $cvr_number = '',
      public string $company_name = ''
    ) {}
}