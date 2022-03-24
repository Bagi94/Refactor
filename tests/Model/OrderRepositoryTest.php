<?php


namespace Tests\Model;


use App\Model\Order;
use App\Model\OrderRepository;
use PHPUnit\Framework\TestCase;

class OrderRepositoryTest extends TestCase
{
    private $orderRepository;

    public function setUp(): void
    {
        $this->orderRepository = new OrderRepository();
    }

    public function testLoadingOrders()
    {
        $order1 = new Order(1,2,3,'2021-03-25 14:51:47');
        $order2 = new Order(2,1,2,'2021-03-21 14:00:26');
        $path = __DIR__ . '/../files/orders.csv';

        $orders = $this->orderRepository->loadOrders($path);
        $this->assertEquals([$order1, $order2], $orders);
    }

    public function testIfFileNotFound()
    {
        $path = 'path/to/nowhere/nothing.csv';
        $this->expectException(\Exception::class);
        $this->orderRepository->loadOrders($path);
    }

    public function testWithWrongCSVHeader()
    {
        $path = __DIR__ . '/../files/wrong_header.csv';
        $this->expectException(\Exception::class);
        $this->orderRepository->loadOrders($path);
    }


}