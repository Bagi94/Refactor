<?php


namespace Tests\Controller;


use App\Controller\OrderController;
use App\Model\OrderRepository;
use PHPUnit\Framework\TestCase;

abstract class BaseOrderControllerTest extends TestCase
{
    /**
     * @var OrderController
     */
    protected $orderController;

    public function setUp(): void
    {
        $this->orderController = new OrderController(new OrderRepository());
    }

}