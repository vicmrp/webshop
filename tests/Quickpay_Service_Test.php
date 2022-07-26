<?php
use \PHPUnit\Framework\TestCase;
use vezit\api\quickpay_api\Quickpay_API;
use vezit\repositories\super_repository\Super_Repository;
use vezit\services\quickpay_service\Quickpay_Service;

require __DIR__ . '/../global-requirements.php';


class Quickpay_Service_Test  extends TestCase
{
    protected function setUp() : void {
        $this->id = null;
        $this->order_id = g_generate_random_string();
        $this->quickpay_service = Quickpay_Service::get_instance();
    }


    protected function tearDown(): void
    {
    }

    /** @test */
    public function create_a_new_payment__shall_return_a_random_payment_that_matches_the_id() {
        $new_payment = $this->quickpay_service->create_a_new_payment($this->order_id);

        $this->assertEquals($this->order_id, $new_payment->order_id);

    }

    /** @test */
    public function create_a_new_payment__shall_return_a_random_payment_that_matches_the_id__mocking() {

        $mock_quickpay_api = $this->createMock(Quickpay_API::class);
        $mock_quickpay_api->method('call_create_a_new_payment')->willReturn(json_decode("{\"order_id\": \"$this->order_id\"}"));
        $this->quickpay_service = Quickpay_Service::get_instance($mock_quickpay_api);

        $new_payment = $this->quickpay_service->create_a_new_payment($this->order_id);

        $this->assertEquals($this->order_id, $new_payment->order_id);
    }



}