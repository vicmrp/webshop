<?php

namespace vezit\classes\error;
require __DIR__.'/../../global-requirements.php';

class Error {
  public $error_message;

  public function __construct(string $filepath, string $error_message, bool $fatal_error) {

    $this->error_message = "PHP vicre: $error_message in $filepath";
    error_log($this->error_message, 0);

    // if ($fatal_error) {
    //   $this->error_message = "PHP vicre Fatal error: $error_message in $filepath";
    //   die(json_encode($this, JSON_PRETTY_PRINT) . PHP_EOL);
    // }
  }
}