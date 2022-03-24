<?php


namespace Tests;


use App\Controller\OrderController;
use App\Model\Order;
use App\Model\OrderRepository;
use PHPUnit\Framework\TestCase;

class FulFillableOrdersTest extends TestCase
{
    public function testFulfillableOrdersWithInvalidJson()
    {
        $orderController = $this->getOrderController($this->createMockRepository([]));

        $this->expectOutputString('Invalid json!');
        $orderController->getFulfillableOrders('{}');
    }

    public function testFulfillableOrdersWithWrongJSON()
    {
        //test without mocking
        $orderController = new OrderController(new OrderRepository());
        $this->expectOutputString('Invalid json!');
        $orderController->getFulfillableOrders('{"1": }');

    }

    public function testFulfillableOrdersWithInvalidStockData()
    {
        $stockJson = json_encode([
            1 => "apple",
            "apple" => 100,
        ]);
        $orderController = $this->getOrderController($this->createMockRepository([]));

        $this->expectOutputString('Wrong stock data.');
        $orderController->getFulfillableOrders($stockJson);
    }

    public function testFulfillableOrdersWithEmptyOrderArray()
    {
        $orderController = $this->getOrderController($this->createMockRepository([]));

        $this->expectOutputString('There are no available orders now.');
        $orderController->getFulfillableOrders('{"1":4}');
    }

    public function testFulfillableOrdersIfProductAvailableInStock()
    {
        $order1 = new Order(1, 1, 1, '2021-03-23 05:01:29');
        $order2 = new Order(2, 1, 2, '2021-03-23 05:01:29');
        $orders = [$order1, $order2];
        $stock = [1 => 2, 2 => 1];

        $orderController = $this->getOrderController($this->createMockRepository($orders));
        $fulfillableOrders = $orderController->getFulfillableOrders(json_encode($stock));

        $this->assertEquals([$order2, $order1], $fulfillableOrders);
    }

    public function testFulfillableOrdersIfProductNotAvailableInStock()
    {
        $order1 = new Order(100, 1, 1, '2021-03-23 05:01:29');
        $order2 = new Order(111, 100, 1, '2021-03-20 05:01:29');
        $orders = [$order1, $order2];
        $stock = [1 => 2, 111 => 1];

        $orderController = $this->getOrderController($this->createMockRepository($orders));
        $fulfillableOrders = $orderController->getFulfillableOrders(json_encode($stock));

        $this->assertEquals([], $fulfillableOrders);
    }


    protected function createMockRepository(array $ordersToReturn = [])
    {
        $orderRepositoryMock = $this->createMock(OrderRepository::class);
        $orderRepositoryMock
            ->expects($this->any())
            ->method('loadOrders')
            ->will($this->returnValue($ordersToReturn));
        return $orderRepositoryMock;
    }

    protected function getOrderController($repository)
    {
        return $this->orderController = new OrderController($repository);
    }
}