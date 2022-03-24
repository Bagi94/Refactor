<?php


namespace Tests\Controller;


use App\Model\Order;

class SelectFulfillableOrdersTest extends BaseOrderControllerTest
{
    public function testSelectWithEmptyOrdersAndEmptyStock()
    {
        $result = $this->orderController->selectFulfillableOrdersByStock([], []);
        $this->assertEquals([], $result);
    }

    public function testSelectIfProductInStock()
    {
        $order = new Order(1,1,1,'2022-03-23 20:00:00');
        $orders = [$order];
        $stock = [1 => 1];
        $result = $this->orderController->selectFulfillableOrdersByStock($orders, $stock);
        $this->assertEquals($orders, $result);

        $stock = [1 => 100];
        $result = $this->orderController->selectFulfillableOrdersByStock($orders, $stock);
        $this->assertEquals($orders, $result);
    }

    public function testSelectIfProductNotAvailableInStock()
    {
        $order = new Order(1,10,1,'2022-03-23 20:00:00');
        $orders = [$order];
        $stock = [1 => 9];
        $result = $this->orderController->selectFulfillableOrdersByStock($orders, $stock);
        $this->assertEquals([], $result);

        $stock = [2 => 100];
        $result = $this->orderController->selectFulfillableOrdersByStock($orders, $stock);
        $this->assertEquals([], $result);
    }

    public function testSelectWithEmptyStock()
    {
        $order = new Order(1,10,1,'2022-03-23 20:00:00');
        $orders = [$order];
        $stock = [];
        $result = $this->orderController->selectFulfillableOrdersByStock($orders, $stock);
        $this->assertEquals([], $result);
    }

    public function testSelectWithoutOrders()
    {
        $orders = [];
        $stock = [2 => 100];
        $result = $this->orderController->selectFulfillableOrdersByStock($orders, $stock);
        $this->assertEquals([], $result);
    }


}