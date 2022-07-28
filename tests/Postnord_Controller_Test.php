<?php
use \PHPUnit\Framework\TestCase;
use vezit\controllers\postnord_controller\Postnord_Controller;


require __DIR__ . '/../global-requirements.php';

class Postnord_Controller_Test extends TestCase
{
    protected function setUp() : void
    {
        $this->postnord_controller = Postnord_Controller::get_instance(
            'GET',
            $url_parameters = [
                "query"          => urlencode('get-service-points')
                ,"streetname"    => urlencode('øresundshoj 3a')
                ,"zip-code"      => urlencode('2920')
            ],
            null,
            null
        );





    }

    protected function tearDown(): void
    {
        Postnord_Controller::destroy_instance();
    }



    /** @test */
    public function get_json_response__get_service_points() {

        $json = $this->postnord_controller->get_json_response();

        $service_points = json_decode($json);

        $this->assertIsArray($service_points);

    }
}
