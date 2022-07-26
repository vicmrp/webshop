<?php

use PhpParser\Node\Expr\Instanceof_;
use \PHPUnit\Framework\TestCase;
use vezit\api\postnord_api\Postnord_API;
use vezit\api\dawa_api\Dawa_API;
use vezit\services\postnord_service\Postnord_Service;
use vezit\dto\Postnord_Service_Point_Response;

require __DIR__ . '/../global-requirements.php';

class Postnord_Service_Test  extends TestCase
{
    protected function setUp() : void {
        $this->postnord_service = Postnord_Service::get_instance();
    }


    /** @test */
    public function get_service_points__returns_array() {
        $service_points = $this->postnord_service->get_service_points("vinkelvej", "2800");
        $this->assertEquals('5517', $service_points[0]->service_point_id);
    }


    /** @test */
    public function get_by_id__return_correct_item() {
        $id = 106617; // "Nærboks Lyngby Lokal Station - Kræver Postnord App"

        $service_point =  $this->postnord_service->get_by_id($id);
        $name = $service_point->name;

        $this->assertEquals("Nærboks Lyngby Lokal Station - Kræver Postnord App", $name);


    }
}
