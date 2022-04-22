<?php
namespace vezit\entities\class\customer\company;

class Company
{
  public function __construct(
      public string $cvr_number = '',
      public string $company_name = ''
    ) {}
}