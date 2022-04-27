<?php
require __DIR__ . '/../global-requirements.php';




use \PHPUnit\Framework\TestCase;
use vezit\entities\session\Session_Entity;
use vezit\dto\session\Session;
use vezit\entities\class\order\item\Item;
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


        $order_id = 12;

        $session_entity = new Session_Entity(
            $session_pk                                     = null,
            $order_id                                       = $order_id
        );


        $item = new Item(
            $session_order_items_pk = null,
            $order_id = $order_id,
            $product_id = 1,
            $product_name = 'roman',
            $price = 12000,
            $quantity = 1
        );
        $session_entity->set_order_items($array_of_items = [$item]);


        $succes = $this->session_repository->insert($session_entity);

        $this->assertTrue($succes , true);

    }
}
