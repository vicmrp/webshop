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
use vezit\classes\login\Login;
use vezit\entities\User;
use vezit\entities\Users;

class Login_Service_Test extends TestCase
{
    protected function setUp() : void
    {


        $this->login_request = new Login_Request();
        $this->login_request->email = 'victor@vezit.net';
        $this->login_request->password = 'Passw0rd';

        // Mock user repo
        $mocked_user_repository = $this->createMock(User_Repository::class);
        $mocked_users = new Users;
        $mocked_users->set([new User(
            $user_pk                  = 0,
            $datetime_created         = null,
            $datetime_last_modified   = null,
            $email                    = 'victor@vezit.net',
            $hashed_password          = '$2y$10$DbNB.IE91t21TPPq7N1/z.6OeuyjlzZHfjEGuyWHwhN3OQrQgeTnS' // 'Passw0rd'
        )]);
        $mocked_user_repository->method('get_all')->willReturn($mocked_users);

        $this->login_service = Login_Service::get_instance($mocked_user_repository);

    }

    protected function tearDown(): void
    {
        if (isset($_SESSION['login_response'])) unset($_SESSION['login_response']);
    }



    /** @test */
    public function validate_user_credentials__expects_empty_login_response_because_user_does_not_exist()
    {
        $login_response = $this->login_service->validate_user_credentials($this->login_request);
        $this->assertEquals($this->login_request->email, $login_response->email);
        $this->assertEquals(true, $login_response->access_granted);
        $this->assertEquals(false, $login_response->session_variable_isset);
        $this->assertEquals('Your username and password had a match in the db!', $login_response->message);
        $this->assertInstanceOf(Login_Response::class, $login_response);
    }


    /** @test */
    public function validate_user_credentials__expects_access_not_granted_even_though_session_var_isset()
    {
        $login_request_correct_credentials = new Login_Request('victor@vezit.net', 'Passw0rd');
        $login_request_wrong_credentials = new Login_Request('doesnotexist@vezit.net', 'wrong password');

        $this->assertEquals("Your username and password had no match in the db!", $this->login_service->validate_user_credentials($login_request_wrong_credentials)->message);
        $this->assertEquals("Your username and password had a match in the db!", $this->login_service->validate_user_credentials($login_request_correct_credentials)->message);
        $this->assertEquals("You were already logged in - session variable isset", $this->login_service->validate_user_credentials($login_request_wrong_credentials)->message);
    }


}
