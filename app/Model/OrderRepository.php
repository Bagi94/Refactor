<?php


namespace App\Model;

use Exception;

class OrderRepository
{
    const FILE_PATH = __DIR__ . '/../orders.csv';

    const EXPECTED_HEADER = [
        'product_id',
        'quantity',
        'priority',
        'created_at'
    ];

    public function loadOrders($path = self::FILE_PATH)
    {
        //check if file exists on the path
        if (!file_exists($path)) {
            throw new Exception('File not found.');
        }
        $orders = [];
        $row = 1;
        if (($handle = fopen($path, 'r')) !== false) {
            while (($data = fgetcsv($handle)) !== false) {
                if ($row == 1) {
                    if ($data != self::EXPECTED_HEADER) {
                        throw new Exception('Unexpected csv header.');
                    }
                } else {
                    $order = new Order($data[0], $data[1], $data[2], $data[3]);
                    array_push($orders, $order);
                }
                $row++;
            }
            fclose($handle);
        } else {
            throw new Exception('Unable to open file: ' . $path);
        }

        return $orders;
    }

}