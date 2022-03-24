<?php

require 'vendor/autoload.php';

use App\Controller\OrderController;
use App\Model\OrderRepository;
//include 'app\Controller\OrderController.php';
//include 'app\Model\OrderRepository.php';

$orderRepository = new OrderRepository();
$controller = new OrderController($orderRepository);

if ($argc != 2) {
    echo 'Ambiguous number of parameters!';
    exit(1);
}

$controller->getFulfillableOrders($argv[1]);