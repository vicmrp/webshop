<?php namespace vezit\controllers;

require __DIR__.'/../../global-requirements.php';

use vezit\services\postnord_service\Postnord_Service;


class Postnord_Controller
{
    public function __construct(
        private ?string $_request_method = null,
        private ?Postnord_Service $_postnord_service = null
    )
    {

    }

}
