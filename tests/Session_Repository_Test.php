<?php
require __DIR__ . '/../global-requirements.php';




use \PHPUnit\Framework\TestCase;
use vezit\entities\session\Session;
use vezit\entities\class\order\item\Item;
use vezit\repositories\session_repository\Session_Repository;

class Session_Repository_Test extends TestCase
{
    protected function setUp() : void
    {
        $this->session_repository = new Session_Repository();
    }

    /** @test */
    public function find_by_pk__shall_return_correct_type()
    {
        // Setup
        $array_of_session = $this->session_repository->get_all();
        $session_pk = $array_of_session[0]->session_pk;

        // Assert
        $this->assertInstanceOf(Session::class, $this->session_repository->find_by_pk($session_pk));
    }


    /** @test */
    public function get_all__shall_return_correct_type()
    {
        // Act
        $array_of_sessions = $this->session_repository->get_all();

        // Assert
        foreach ($array_of_sessions as $session) {
            if (!($session instanceof Session)) {
                $this->fail('Session_Repository::get_all() shall return an array of Session_Entity objects');
            }
        }

        $this->assertIsArray($array_of_sessions);
    }


    /** @test */
    public function find_by_order_id__shall_return_correct_type()
    {
        // Setup
        $array_of_session = $this->session_repository->get_all();
        $order_id = $array_of_session[0]->order_id;

        // Act
        $session_entity = $this->session_repository->find_by_order_id($order_id);

        // Assert
        $this->assertInstanceOf(Session::class, $session_entity);
    }


    // public function insert__check_if_you_can_insert_a_session_object()
    // {
    //     // Arrange
    //     // Hent seneste order_id



    //     // Hent seneste order_id


    //     $order_id = 15;

    //     $session_entity = new Session_Entity(
    //         $session_pk                                     = null,
    //         $order_id                                       = $order_id
    //     );


    //     $item = new Item(
    //         $session_order_items_pk = null,
    //         $order_id = $order_id,
    //         $product_id = 1,
    //         $product_name = 'roman',
    //         $price = 12000,
    //         $quantity = 1
    //     );
    //     $session_entity->set_order_items($array_of_items = [$item]);


    //     $succes = $this->session_repository->insert($session_entity);

    //     $this->assertTrue($succes , true);

    // }
}
