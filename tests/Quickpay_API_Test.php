<?php
use \PHPUnit\Framework\TestCase;
use vezit\api\quickpay_api\Quickpay_API;

require __DIR__ . '/../global-requirements.php';


class Quickpay_API_Test  extends TestCase

{
    protected function setUp() : void {
        $this->id = null;
        $this->order_id = g_generate_random_string();
        $this->quickpay_api = Quickpay_API::get_instance();
    }


    /** @test */
    public function call_create_a_new_payment__shall_return_a_random_payment_that_matches_the_id() {
        $new_payment = $this->quickpay_api->call_create_a_new_payment($this->order_id);
        $this->id = $new_payment->id;
        $this->assertEquals($this->order_id, $new_payment->order_id);
        return $this->id;
    }


    /**
     * @test
     * @depends call_create_a_new_payment__shall_return_a_random_payment_that_matches_the_id
     */
    public function call_get_payment__returns_an_existing_payment($id) {

        $payment = $this->quickpay_api->call_get_payment($id);
        $this->assertEquals($id, $payment->id);
    }




    /**
     * @test
     * @depends call_create_a_new_payment__shall_return_a_random_payment_that_matches_the_id
     */
    public function call_get_payment_link__shall_return_payment_link($id)
    {
        // $id = '1234567890';
        $url = $this->quickpay_api->call_get_payment_link($id, $amount = 100000);
        $this->assertStringStartsWith("https://payment.quickpay.net/payments/", $url);
    }




}
