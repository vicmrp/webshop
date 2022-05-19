<?php
namespace vezit\models\session\customer\company;

class Company
{
  public function __construct(
      public ?string $cvr_number    = null,
      public ?string $company_name  = null
    ) {}
}