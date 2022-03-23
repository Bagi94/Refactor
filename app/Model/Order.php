<?php

namespace App\Model;

use Exception;

class Order
{
    const PRIORITY_LABELS = [
        1 => 'low',
        2 => 'medium',
        3 => 'high'
    ];

    /**
     * @var int
     */
    private $productId;

    /**
     * @var int
     */
    private $quantity;

    /**
     * @var int
     */
    private $priority;

    /**
     * @var string
     */
    private $createdAt;

    public function __construct($productId = null, $quantity = null, $priority = null, $createdAt = null)
    {
        $this->productId = $productId;
        $this->quantity = $quantity;
        $this->priority = $priority;
        $this->createdAt = $createdAt;
    }

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->productId;
    }

    /**
     * @param int $productId
     */
    public function setProductId(int $productId): void
    {
        $this->productId = $productId;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getPriorityLabel(): string
    {
        if (!array_key_exists($this->priority, self::PRIORITY_LABELS)) {
            throw new Exception('There is no available label for priority: ' . $this->priority);
        }
        return self::PRIORITY_LABELS[$this->priority];
    }

    /**
     * @param int $priority
     */
    public function setPriority(int $priority): void
    {
        $this->priority = $priority;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @param string $createdAt
     */
    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function isFulfillable($stockQuantity)
    {
        return $this->quantity <= $stockQuantity ? true : false;
    }

}