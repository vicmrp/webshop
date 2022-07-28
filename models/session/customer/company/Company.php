<?php
namespace vezit\models\session\customer\company;

class Company
{
  public function __construct(
      public ?string $cvr_number    = null,
      public ?string $company_name  = null
    ) {}

    public function __set($name, $value)
    {
        throw new \Exception('Cant set!' . $name . ', ' . $value);
    }
}