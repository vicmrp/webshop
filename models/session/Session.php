<?php namespace vezit\models\session;
use vezit\models\session\customer\Customer;
use vezit\models\session\order\Order;
require __DIR__ . '/../../global-requirements.php';

class Session
{
    public function __construct(
        public Customer $customer = new Customer,
        public Order $order = new Order
    )
    {}

    public function __set($name, $value)
    {
        throw new \Exception('Cant set!' . $name . ', ' . $value);
    }
}
