<?php
use \PHPUnit\Framework\TestCase;
use vezit\api\dawa_api\Dawa_API;
require __DIR__ . '/../global-requirements.php';

class Dawa_API_Test  extends TestCase
{
    protected function setUp() : void {
        $this->dawa_api = new Dawa_API;
    }


    /** @test */
    public function call_get_sanitized_address__() {
        $sanitized_address = $this->dawa_api->call_get_sanitized_address('Vinkelvej 12d 3tv', '2800');

        $this->assertEquals("Vinkelvej", $sanitized_address->street_name);
    }
}
