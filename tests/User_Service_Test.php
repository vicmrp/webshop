<?php
require __DIR__ . '/../global-requirements.php';

use vezit\dto\post_login_response\Post_Login_Response;
use vezit\dto\post_login_request\Post_Login_Request;


use vezit\services\user_service\User_Service;
use vezit\repositories\user_repository\User_Repository;

use vezit\services\session_variables_service\Session_Variables_Service;
use vezit\dto\put_update_user_request\Put_Update_User_Request;

use \PHPUnit\Framework\TestCase;

use vezit\entities\User;
use vezit\entities\Users;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertTrue;

class User_Service_Test extends TestCase
{
    public $post_login_request = null;
    public $user_service = null;

    protected function setUp() : void
    {


        $this->post_login_request = new Post_Login_Request();
        $this->post_login_request->email = 'victor@vezit.net';
        $this->post_login_request->password = 'Passw0rd';

        // Mock user repo
        $mocked_user_repository = $this->createMock(User_Repository::class);
        $mocked_users = new Users;
        $mocked_users->set(['victor@vezit.net' =>
            new User(
                $user_pk                  = 0,
                $datetime_created         = null,
                $datetime_last_modified   = null,
                $email                    = 'victor@vezit.net',
                $hashed_password          = '$2y$10$DbNB.IE91t21TPPq7N1/z.6OeuyjlzZHfjEGuyWHwhN3OQrQgeTnS' // 'Passw0rd'
            )
        ]
    );


        $mocked_user_repository->method('get_all')->willReturn($mocked_users);


        $this->user_service = User_Service::get_instance($mocked_user_repository);

    }

    protected function tearDown(): void
    {
        Session_Variables_Service::get_instance()->delete_all_session_variables();
    }



    /** @test */
    public function validate_user_credentials__expects_empty_login_response_because_user_does_not_exist()
    {
        $post_login_response = $this->user_service->validate_user_credentials($this->post_login_request);
        $this->assertEquals($this->post_login_request->email, $post_login_response->email);
        $this->assertEquals(true, $post_login_response->access_granted);
        $this->assertEquals('Your username and password had a match in the db!', $post_login_response->message);
        $this->assertInstanceOf(Post_Login_Response::class, $post_login_response);
    }




    // Update user
    /** @test */
    public function update() {
        // setup
        // login in first
        //
        $session_variables_service = Session_Variables_Service::get_instance();

        $post_login_response = $session_variables_service->post_login_response();
        $post_login_response->email = 'victor.reipur@gmail.com';
        $post_login_response->access_granted = true;
        $post_login_response->message = "super hack";
        $session_variables_service->update_post_login_response($post_login_response);




        // Existing user
        $put_update_user_request = new Put_Update_User_Request($new_password  = '12345678');

        User_Service::destroy_instance();
        $this->user_service = User_Service::get_instance();

        $update_user_resposne = $this->user_service->update($put_update_user_request);

        $this->assertTrue($update_user_resposne->password_has_been_updated);





    }


    public function logout() {
        // setup
        // login in first
        //
        $session_variables_service = Session_Variables_Service::get_instance();

        $post_login_response = $session_variables_service->post_login_response();
        $post_login_response->email = 'victor.reipur@gmail.com';
        $post_login_response->access_granted = true;
        $post_login_response->message = "super hack";
        $session_variables_service->update_login_response($post_login_response);


        User_Service::destroy_instance();
        $this->user_service = User_Service::get_instance();

        $get_login_response = $this->user_service->logout();

        $this->assertEquals($get_login_response->message, "user has been logged out", "user has been logged out");
        $this->assertTrue($get_login_response->access_granted, 'user has been logged out');


    }


    // Create user
    /** @test */
}
