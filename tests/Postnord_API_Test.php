<?php
use \PHPUnit\Framework\TestCase;
use vezit\api\postnord_api\Postnord_API;
use vezit\api\dawa_api\Dawa_API;
use vezit\dto\Postnord_Service_Point_Response;

require __DIR__ . '/../global-requirements.php';

class Postnord_API_Test  extends TestCase
{
    protected function setUp() : void {
        $this->dawa_api = new Dawa_API;
        $this->postnord_api = new Postnord_API;
    }


    /** @test */
    public function call_get_servicepoints() {
        $sanitized_address = $this->dawa_api->call_get_sanitized_address('Vinkelvej 12d 3tv', '2800');

        $service_points = $this->postnord_api->call_get_servicepoints($sanitized_address, 2);

        $this->assertIsArray($service_points);
        $this->assertInstanceOf(Postnord_Service_Point_Response::class, $service_points[array_key_first($service_points)]);
    }
}
