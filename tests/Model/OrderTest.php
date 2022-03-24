<?php

namespace Tests\Model;

use App\Model\Order;
use PHPUnit\Framework\TestCase;


final class OrderTest extends TestCase
{
    private $order;

    public function setUp(): void
    {
        $this->order = new Order();
    }

    public function testProductIdSetter()
    {
        $expected = 111;
        $this->order->setProductId($expected);
        $this->assertEquals($expected, $this->order->getProductId());
    }

    public function testQuantitySetter()
    {
        $expected = 10;
        $this->order->setQuantity($expected);
        $this->assertEquals($expected, $this->order->getQuantity());
    }

    public function testPrioritySetter()
    {
        $expected = 1;
        $this->order->setPriority($expected);
        $this->assertEquals($expected, $this->order->getPriority());
    }

    public function testCreatedAtSetter()
    {
        $expected = '2021-03-23 05:01:29';
        $this->order->setCreatedAt($expected);
        $this->assertEquals($expected, $this->order->getCreatedAt());
    }

    public function testIsFulfillableOrder()
    {
        $this->order->setQuantity(2);

        $this->assertTrue($this->order->isFulfillable(2));
        $this->assertTrue($this->order->isFulfillable(3));
        $this->assertFalse($this->order->isFulfillable(1));
        $this->assertFalse($this->order->isFulfillable(0));
    }

    public function testPriorityLabelLow()
    {
        $this->order->setPriority(1);
        $this->assertEquals("low", $this->order->getPriorityLabel());
    }

    public function testPriorityLabelMedium()
    {
        $this->order->setPriority(2);
        $this->assertEquals("medium", $this->order->getPriorityLabel());
    }

    public function testPriorityLabelHigh()
    {
        $this->order->setPriority(3);
        $this->assertEquals("high", $this->order->getPriorityLabel());
    }

    public function testPriorityLabelUnknown()
    {
        $order = new Order(1, 2, 10, '2021-03-23 05:01:29');
        $this->expectException(\Exception::class);
        $order->getPriorityLabel();

    }
}