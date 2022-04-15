<?php

use vezit\dto\user\response\Login_Response;
use vezit\services\login_service\Login_Service;
use vezit\repositories\user_repository\User_Repository;
use vezit\dto\login\request\Login_Request;

class Login_Service_Test extends \PHPUnit\Framework\TestCase
{
    protected function setUp() : void
    {
        $this->login_service = new Login_Service(new User_Repository());
    }


    /** @test */
    public function check_login_service_is_correct_instance_of_class()
    {
        $this->assertInstanceOf(Login_Service::class, $this->login_service);
    }

    /** @test */
    public function validate_user_credentials_shall_return_login_response_object()
    {
        // Setup


        // Do something
        $username = 'test@steengede.com';
        $password = 'Passw0rd';

        $login_request = new Login_Request();
        $login_request->username = $username;
        $login_request->password = $password;

        $this->login_service = new Login_Service(new User_Repository());
        $result = $this->login_service->validate_user_credentials($login_request);


        // Assert
        $this->assertSame($username, $result->username);

    }
}
