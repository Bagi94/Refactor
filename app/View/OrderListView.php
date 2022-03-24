<?php


namespace App\View;


use App\Model\Order;

class OrderListView
{
    /**
     * Displays the header and the orders
     * @param $header
     * @param $orders
     */
    public function displayOrderList($header, $orders)
    {
        if (count($orders) > 0) {
            foreach ($header as $item) {
                echo str_pad($item, 20);
            }
            echo PHP_EOL;
            echo str_repeat('=', count($header) * 20);
            echo PHP_EOL;

            /** @var Order $order */
            foreach ($orders as $order) {
                echo str_pad($order->getProductId(), 20);
                echo str_pad($order->getQuantity(), 20);
                echo str_pad($order->getPriorityLabel(), 20);
                echo str_pad($order->getCreatedAt(), 20);
                echo PHP_EOL;
            }
        } else {
            echo 'There is nothing to display..';
        }
    }
}