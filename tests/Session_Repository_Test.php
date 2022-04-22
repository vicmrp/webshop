<?php
require __DIR__ . '/../global-requirements.php';




use \PHPUnit\Framework\TestCase;
use vezit\entities\session\Session_Entity;
use vezit\dto\session\Session;
use vezit\repositories\session_repository\Session_Repository;

class Session_Repository_Test extends TestCase
{
    protected function setUp() : void
    {
        $this->session_repository = new Session_Repository();
    }

    /** @test */
    public function find__shall_return_correct_type()
    {
        $this->assertInstanceOf(Session_Entity::class, $this->session_repository->find(2));
    }

    /** @test */
    public function find__check_if_subtype_can_be_unserialized()
    {
        $session_entity = $this->session_repository->find(2);

        $session = unserialize($session_entity->serialized_session);


        $this->assertInstanceOf(Session::class, $session);
    }

    /** @test */
    public function insert__check_if_you_can_insert_an_object()
    {


        $session_entity = new Session_Entity(
        );


        $succes = $this->session_repository->insert($session_entity);

        $this->assertTrue($succes , true);

    }
}
