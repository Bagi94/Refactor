<?php


namespace App\Controller;

use App\Model\Order;
use App\Model\OrderRepository;
use App\View\OrderListView;
use Exception;
use JsonException;

class OrderController
{
    /**
     * @var OrderRepository
     */
    private $orderRepository;

    public function __construct($orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * Displays and returns the fulfillable orders by the input stock
     * parameter sorted by priority and created date.
     * @param $stockJSON
     * @return array|void
     */
    public function getFulfillableOrders($stockJSON)
    {
        try {
            $stock = $this->convertJSONParameterToArray($stockJSON);
        } catch (Exception $exception) {
            echo $exception->getMessage();
            return;
        }

        if (!$this->isValidStock($stock)) {
            echo 'Wrong stock data.';
            return;
        }

        $orders = [];
        try {
            //Load all orders from file
            $orders = $this->orderRepository->loadOrders();
        } catch (Exception $exception) {
            echo $exception->getMessage();
            return;
        }

        //if there are no orders
        if (count($orders) == 0) {
            echo 'There are no available orders now.';
            return;
        }

        //get the fulfillable orders by stock data
        $fulfillableOrders = $this->selectFulfillableOrdersByStock($orders, $stock);

        //sorting by priority and date of creation
        $this->sortOrdersByPriorityDescAndCreatedAtAsc($fulfillableOrders);

        //displays the result
        $view = new OrderListView();
        $view->displayOrderList(OrderRepository::EXPECTED_HEADER, $fulfillableOrders);

        return $fulfillableOrders;
    }

    /**
     * Converts the given JSON data to an associative array.
     * @param $param
     * @return mixed
     * @throws JsonException
     */
    public function convertJSONParameterToArray($param)
    {
        if (($array = json_decode($param, true)) == null) {
            throw new JsonException('Invalid json!');
        }
        return $array;
    }

    /**
     * Validates stock array
     * @param array $stock
     * @return bool
     * Returns TRUE if product ids (array keys) are positive integers and quantities (values) are positive integers or 0.
     */
    public function isValidStock(array $stock)
    {
        foreach ($stock as $prodId => $quantity) {
            if ((is_int($prodId) && $prodId > 0) && (is_int($quantity) && $quantity >= 0)) {
                continue;
            } else {
                return false;
            }
        }
        return true;
    }

    /**
     * Returns an array of fulfillable orders.
     * @param $orders
     * @param $stock
     * @return array
     */
    public function selectFulfillableOrdersByStock(array $orders, array $stock)
    {
        $fulfillableOrders = [];

        /** @var Order $order */
        foreach ($orders as $order) {
            // first check if product is in stock
            if (array_key_exists($productId = $order->getProductId(), $stock)) {
                //then check by the available quantity
                if ($order->isFulfillable($stock[$productId])) {
                    array_push($fulfillableOrders, $order);
                }
            }
        }
        return $fulfillableOrders;
    }

    /**
     * @param array $orders
     */
    public function sortOrdersByPriorityDescAndCreatedAtAsc(array &$orders)
    {
        usort($orders, function (Order $a, Order $b) {
            $pc = -1 * ($a->getPriority() <=> $b->getPriority());
            return $pc == 0 ? $a->getCreatedAt() <=> $b->getCreatedAt() : $pc;
        });

    }
}