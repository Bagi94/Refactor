<?php


namespace Tests\Controller;


use App\Model\Order;

class SortingOrdersByPriorityAndCreatedTest extends BaseOrderControllerTest
{
    public function testSortingOrdersByPriorityDescAndCreatedAtAsc()
    {
        $order1 = new Order(1, 1, 1, '2021-03-23 05:01:29');
        $order2 = new Order(1, 1, 2, '2021-03-23 05:01:29');
        $order3 = new Order(1, 1, 2, '2021-03-20 05:01:29');
        $order4 = new Order(1, 1, 3, '2021-03-23 05:01:29');
        $order5 = new Order(1, 1, 3, '2021-03-21 05:01:29');
        $order6 = new Order(1, 1, 3, '2021-03-25 05:01:29');

        $orders = [
            $order1,
            $order2,
            $order3,
            $order4,
            $order5,
            $order6
        ];

        $expectedOrders = [
            $order5,
            $order4,
            $order6,
            $order3,
            $order2,
            $order1,
        ];
        $this->assertNotEquals($expectedOrders, $orders);

        $this->orderController->sortOrdersByPriorityDescAndCreatedAtAsc($orders);

        $this->assertEquals($expectedOrders, $orders);
    }

    public function testSortingOrdersWithEmptyArray()
    {
        $orders = [];
        $this->orderController->sortOrdersByPriorityDescAndCreatedAtAsc($orders);
        $this->assertEquals([], $orders);
    }

    public function testSortingOrdersWithSingleItemArray()
    {
        $order = new Order(1,1,1,'2022-03-23 20:00:00');
        $orders = [$order];
        $this->orderController->sortOrdersByPriorityDescAndCreatedAtAsc($orders);
        $this->assertEquals([$order], $orders);
    }

    public function testSortingOrdersWithSimilarItems()
    {
        $order1 = new Order(1,1,1,'2022-03-23 20:00:00');
        $order2 = new Order(1,1,1,'2022-03-23 20:00:00');

        $orders = [$order1, $order2];
        $this->orderController->sortOrdersByPriorityDescAndCreatedAtAsc($orders);
        $this->assertEquals([$order1, $order2], $orders);

        //in reverse order
        $orders = [$order2, $order1];
        $this->orderController->sortOrdersByPriorityDescAndCreatedAtAsc($orders);
        $this->assertEquals([$order2, $order1], $orders);

        //with exactly the same items
        $orders = [$order1, $order1];
        $this->orderController->sortOrdersByPriorityDescAndCreatedAtAsc($orders);
        $this->assertEquals([$order1, $order1], $orders);
    }

    public function testSortingOrdersWithNonOrders()
    {
        $orders = [1, 2];
        $this->expectException(\TypeError::class);
        $this->orderController->sortOrdersByPriorityDescAndCreatedAtAsc($orders);
    }
}