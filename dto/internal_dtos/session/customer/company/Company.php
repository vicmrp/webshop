<?php
namespace vezit\dto\internal_dtos\session\customer\company;

class Company
{
  public function __construct(
      public ?string $cvr_number    = null,
      public ?string $company_name  = null
    ) {}
}