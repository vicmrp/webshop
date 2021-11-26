<?php

namespace vezit\classes\tspa;

require __DIR__.'/../../global-requirements.php';

class Tspa
{
  public function get_ou_folder($computername) : string {
    
  }

  public function get_powershell_script(string $computername) : string {
    return $computername;
  }

}
