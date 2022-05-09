<?php
require __DIR__ . '/../global-requirements.php';

use vezit\dto\login\response\Login_Response;
use vezit\dto\login\response\Is_User_Logged_In_Response;
use vezit\services\login_service\Login_Service;
use vezit\repositories\user_repository\User_Repository;
use vezit\dto\login\request\Login_Request;
use \PHPUnit\Framework\TestCase;
use vezit\entities\user\User;

class Login_Service_Test extends TestCase
{
    protected function setUp() : void
    {
        $this->login_service = new Login_Service(new User_Repository());

        $this->login_request = new Login_Request();
        $this->login_request->username = 'test@steengede.com';
        $this->login_request->password = 'Passw0rd';
    }



    /** @test */
    public function validate_user_credentials_shall_return_correct_instance_of_class()
    {
        $login_response = $this->login_service->validate_user_credentials($this->login_request);

        $this->assertInstanceOf(Login_Response::class, $login_response);
    }



    /** @test */
    public function validate_user_credentials_shall_return_login_response_with_test_user_object_from_database()
    {
        // Setup


        // Do something
        $login_response = $this->login_service->validate_user_credentials($this->login_request);


        // Assert
        $this->assertSame($this->login_request->username, $login_response->username);
    }



    /** @test */
    public function validate_user_credentials_shall_return_login_response_with_access_granted_as_true_using_mocking()
    {

        // Setup
        $mock_entity_user = $this->createMock(User::class);
        $mock_entity_user->id = 1;
        $mock_entity_user->email = 'test@steengede.com';
        $mock_entity_user->hash = '$2y$10$DbNB.IE91t21TPPq7N1/z.6OeuyjlzZHfjEGuyWHwhN3OQrQgeTnS';
        $mock_entity_user->role = 0;

        $mock_user_repository = $this->createMock(User_Repository::class);
        $mock_user_repository->method('get_user_by_email')->willReturn($mock_entity_user);

        // Do something
        $login_service = new Login_Service($mock_user_repository);
        $login_response = $login_service->validate_user_credentials($this->login_request);

        // Assert
        $this->assertTrue($login_response->access_granted);
    }





    /** @test */
    public function check_if_user_is_logged_in__shall_return_correct_instance_of_class()
    {
        $is_user_logged_in_response = $this->login_service->check_if_user_is_logged_in();
        $this->assertInstanceOf(Is_User_Logged_In_Response::class, $is_user_logged_in_response);
    }



    /** @test */
    public function logout_shall_return_correct_instance_of_class()
    {
        $is_user_logged_in_response = $this->login_service->logout();
        $this->assertInstanceOf(Is_User_Logged_In_Response::class, $is_user_logged_in_response);
    }
}
