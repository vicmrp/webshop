<?php
require __DIR__ . '/../global-requirements.php';

use vezit\dto\Login_Response;
use vezit\dto\Login_Request;
use vezit\dto\Is_User_Logged_In_Response;
use vezit\services\login_service\Login_Service;
use vezit\repositories\user_repository\User_Repository;
use vezit\repositories\super_repository\Super_Repository;
use vezit\classes\mysqli\Mysqli;
use \PHPUnit\Framework\TestCase;
use vezit\entities\User;
use vezit\entities\Users;

class Login_Service_Test extends TestCase
{
    protected function setUp() : void
    {
        $this->login_service = new Login_Service(new User_Repository(new Super_Repository(new Mysqli('localhost', 'test', 'Passw0rd', 'test_user_v6_vezit_webshop'))));

        $this->login_request = new Login_Request();
        $this->login_request->email = 'test@steengede.com';
        $this->login_request->password = 'Passw0rd';
    }



    /** @test */
    public function validate_user_credentials__shall_return_correct_instance_of_class()
    {
        $login_response = $this->login_service->validate_user_credentials($this->login_request);
        $this->assertInstanceOf(Login_Response::class, $login_response);
    }



    /** @test */
    public function validate_user_credentials__shall_return_login_response_with_test_user_object_from_database()
    {
        // Setup


        // Do something
        $login_response = $this->login_service->validate_user_credentials($this->login_request);


        // Assert
        $this->assertSame($this->login_request->email, $login_response->email);
    }



    /** @test */
    public function validate_user_credentials__shall_return_login_response_with_access_granted_as_true_using_mocking()
    {

        // Setup

        $mock_users = new Users;
        $mock_users->set([new User(
            $user_pk                  = 0,
            $datetime_created         = null,
            $datetime_last_modified   = null,
            $email                    = 'victor@steengede.com',
            $hashed_password          = '$2y$10$DbNB.IE91t21TPPq7N1/z.6OeuyjlzZHfjEGuyWHwhN3OQrQgeTnS' // 'Passw0rd'
        )]);

        $mock_user_repository = $this->createMock(User_Repository::class);
        $mock_user_repository->method('get_all')->willReturn($mock_users);

        $login_service = new Login_Service($mock_user_repository);

        // Do something
        $login_request = new Login_Request(
            'victor@steengede.com',
            'Passw0rd'
        );


        $login_response = $login_service->validate_user_credentials($login_request);

        // Assert
        $this->assertTrue($login_response->access_granted);
    }





    /** @test */
    public function check_if_user_is_logged_in__shall_return_correct_instance_of_class_using_mock()
    {

    $login_service = new Login_Service(new User_Repository(), new Login_Response('victor@gmail.com', true, true, ""));

        $login_response = $login_service->check_if_user_is_logged_in();

        $this->assertInstanceOf(Login_Response::class, $login_response);
        $this->assertTrue($login_response->access_granted);
        $this->assertEquals("You are logged in", $login_response->message);

    }



    /** @test */
    public function logout_shall_return_correct_instance_of_class()
    {
        $login_response = $this->login_service->logout();

        $this->assertInstanceOf(Login_Response::class, $login_response);
        $this->assertEquals("You are now logged out", $login_response->message);
    }
}
