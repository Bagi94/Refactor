<?php


namespace Tests\Controller;


class StockValidatorTest extends BaseOrderControllerTest
{
    public function testStockValidatorReturnsTrue()
    {
        //productId and quantity are positive integers
        $stock = [1 => 2];
        $this->assertTrue($this->orderController->isValidStock($stock));

        //test with multiple items
        $stock = [1 => 2, 2 => 2];
        $this->assertTrue($this->orderController->isValidStock($stock));

        //quantity can be zero or positive integer
        $stock = [1 => 2, 2 => 0];
        $this->assertTrue($this->orderController->isValidStock($stock));

    }

    public function testStockValidatorReturnsFalse()
    {
        //productId can not be zero
        $stock = [0 => 2];
        $this->assertFalse($this->orderController->isValidStock($stock));

        //quantity can not be negative
        $stock = [1 => -2];
        $this->assertFalse($this->orderController->isValidStock($stock));

        //productId can not be negative
        $stock = [-1 => -2];
        $this->assertFalse($this->orderController->isValidStock($stock));

        //productId and quantity must be integer
        $stock = ['a' => 2];
        $this->assertFalse($this->orderController->isValidStock($stock));

        $stock = [1 => 'b'];
        $this->assertFalse($this->orderController->isValidStock($stock));

        $stock = ['2' => 'b'];
        $this->assertFalse($this->orderController->isValidStock($stock));

        $stock = [4 => 1.3];
        $this->assertFalse($this->orderController->isValidStock($stock));

        $stock = [1 => [1 => 2]];
        $this->assertFalse($this->orderController->isValidStock($stock));

        //test with multiple items
        $stock = [1 => 2, 2 => 'a'];
        $this->assertFalse($this->orderController->isValidStock($stock));

        $stock = [1 => 2, 2 => -10];
        $this->assertFalse($this->orderController->isValidStock($stock));

        $stock = [1 => 2, 0 => -10];
        $this->assertFalse($this->orderController->isValidStock($stock));

    }
}