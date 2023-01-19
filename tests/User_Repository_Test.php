<?php

require __DIR__ . '/../global-requirements.php';

use \PHPUnit\Framework\TestCase;
use vezit\repositories\user_repository\User_Repository;
use vezit\entities\User;
use vezit\entities\Users;
use vezit\repositories\super_repository\Super_Repository;
use vezit\classes\mysqli\Mysqli;

class User_Repository_Test extends TestCase
{
    public $user_repository = null;

    protected function setUp() : void
    {
        $this->user_repository = User_Repository::get_instance(
            Super_Repository::get_instance(
                Mysqli::get_instance(
                    'database-service', 'testuser', 'Passw0rd', 'testuser_victorreipur'
                )
            )
        );
    }

    protected function tearDown(): void
    {
        $this->user_repository = null;
    }

    // Mocking every sub classes
    /** @test */
    public function get_all__shall_return_array_of_user_entities()
    {
        $users = $this->user_repository->get_all();

        // Assert
        foreach ($users->get() as $user) {
            if (!($user instanceof User)) {
                $this->fail('User_Repository::get_all() shall return an array of User objects');
            }
        }

        $this->assertInstanceOf(Users::class, $users);
    }

    // Mocking every sub classes
    /** @test */
    public function get_all__shall_return_array_of_user_entities_using_mocking()
    {

        // Arrange
        $dt = new \DateTime;
        $mock_users = new Users;
        $mock_user_1 =  new User(1, $dt, $dt, 'victor.reipur@gmail.com', 'Passw0rd');
        $mock_user_2 =  new User(1, $dt, $dt, 'viggo_mortensen@gmail.com', 'Passw0rd');
        $mock_users->set([1 => $mock_user_1, 2 => $mock_user_2]);

        $mock_user_repository = $this->createMock(User_Repository::class);
        $mock_user_repository->method('get_all')->willReturn($mock_users);

        // Act
        $users = $mock_user_repository->get_all()->get();

        // Assert
        $this->assertEquals($users[1]->email, 'victor.reipur@gmail.com');
        $this->assertEquals($users[2]->email, 'viggo_mortensen@gmail.com');

    }

    // Mocking every sub classes
    /** @test */
    public function get_all__shall_return_array_of_user_entities_using_mocking_on_super_repository() {

        $mock_super_repository = $this->createMock(Super_Repository::class);

        $associative_array = [
            'steengede@gmail.com' =>
            [
                'user_pk' => 2,
                'datetime_created' => "2022-05-15 03:30:50",
                'datetime_last_modified' => "2022-05-15 03:30:50",
                'email' => "steengede@gmail.com",
                'hashed_password' => "password"
            ]
        ];

        $mock_super_repository->method('get_all')
            ->willReturn($associative_array);

        $user_repository = User_Repository::get_instance($mock_super_repository);


        $users = $user_repository->get_all();


        // Assert
        foreach ($users->get() as $user) {
            if (!($user instanceof User)) {
                $this->fail('User_Repository::get_all() shall return an array of User objects');
            }
        }

        $first_array_key = array_key_first($users->get());

        $this->assertInstanceOf(Users::class, $users);
        $this->assertInstanceOf(User::class, $users->get()[$first_array_key]);
        $this->assertEquals("steengede@gmail.com", $users->get()["steengede@gmail.com"]->email);
    }

    /** @test */
    public function get_all_users() {

        $users = $this->user_repository->get_all();

        $this->assertTrue(true, 'for debugging purpose');
    }

    # Create user - proove that you can create a user in a database
    /** @test */
    public function create_user()
    {
        $username = g_generate_random_string();


        $user = new User(
            $user_pk                  = null,
            $datetime_created         = null,
            $datetime_last_modified   = null,
            $email                    = "$username@gmail.com",
            $hashed_password          = '$2y$10$Qlq7ejhtU37yj1rPQKQUr.ewscrn3DJ6z6DcFKVuee7WYDIXCf0uy'
        );




        $user_has_been_updated = $this->user_repository->insert($user);

        $this->assertTrue($user_has_been_updated, $message = 'user has been updated');




    }

    # Update user
    /** @test */
    public function update_user()
    {
        // Get all users
        $email = "victor.reipur@gmail.com";

        // change user password
        $user = new User(
            $user_pk                  = null,
            $datetime_created         = null,
            $datetime_last_modified   = null,
            $email                    = $email,
            $hashed_password          = 'new hashed password: ' . g_generate_random_string()
        );

        // // update
        $user_has_been_updated = $this->user_repository->update($email, $user);

        // $this
        $this->assertTrue($user_has_been_updated, 'user has been updated');


    }

    # Delete user
}
