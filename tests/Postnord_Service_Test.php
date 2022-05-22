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
        foreach ($service_points as $service_point) {
            if (!($service_point Instanceof Postnord_Service_Point_Response)) {
                $this->fail("Not instance of Postnord_Service_Point_Response");
            }
        }
        $this->assertTrue(true);
    }
}
