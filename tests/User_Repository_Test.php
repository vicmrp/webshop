<?php

require __DIR__ . '/../global-requirements.php';

use \PHPUnit\Framework\TestCase;
use vezit\repositories\user_repository\User_Repository;
use vezit\entities\user\User;


class User_Repository_Test extends TestCase
{
    protected function setUp(): void
    {
        $this->user_repository = new User_Repository();
    }


    /** @test */
    public function expects_get_user_by_id_to_return_type_of_user()
    {
        $this->assertInstanceOf(User::class, $this->user_repository->get_user_by_id(1));
    }


    /** @test */
    public function get_user_by_id_shall_return_a_specified_email_non_mocking()
    {

        $email = "test@steengede.com";
        $this->assertSame($email, $this->user_repository->get_user_by_id(1)->email);
    }


    /** @test */
    public function get_user_by_id_shall_return_a_specified_email_using_mocking()
    {
        // Arrange
        $mock_email = "victor.reipur@gmail.com";

        // $mock_user = $this->getMockBuilder(User::class)->disableOriginalConstructor()->getMock();

        // $mock_user->id = 1;
        // $mock_user->email = $mock_email;
        // $mock_user->hash = "hash";
        // $mock_user->role = 0;

        $mock_user = $this->getMockBuilder(User::class)->disableOriginalConstructor()->getMock();

        $mock_user->id = 1;
        $mock_user->email = $mock_email;
        $mock_user->hash = "hash";
        $mock_user->role = 0;

        $mock_user_repository = $this->createMock(User_Repository::class);

        $mock_user_repository->method('get_user_by_id')->willReturn($mock_user);

        // Act
        $email = "victor.reipur@gmail.com";

        // Assert
        $this->assertSame($email, $mock_user_repository->get_user_by_id(1)->email);
    }
}
