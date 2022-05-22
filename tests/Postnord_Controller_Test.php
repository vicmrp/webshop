<?php
use \PHPUnit\Framework\TestCase;
use vezit\controllers\Postnord_Controller;
use vezit\services\postnord_service\Postnord_Service;

require __DIR__ . '/../global-requirements.php';

class Postnord_Controller_Test extends TestCase
{
    protected function setUp() : void
    {






    }

    protected function tearDown(): void
    {

    }

    /** @test */
    public function get_json_response__get_service_points() {

        $postnord_controller = new Postnord_Controller(
            'GET',
            [
                "streetname"    => "%C3%B8resundshoj%203a", // øresundshoj 3a
                "zip-code"      => "2800"
            ],
            null,
            null
        );

        $json = $postnord_controller->get_json_response();

        $x=0;


    }
}