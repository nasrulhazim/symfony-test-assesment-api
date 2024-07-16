<?php

namespace App\Processors\Recommendation;

use App\Contracts\Processors\Recommendation;

class Base implements Recommendation
{
    public function __construct(private $userId, private $purchaseHistory, private $productAttributes)
    {

    }

    public static function make($userId, $purchaseHistory, $productAttributes)
    {
        return (new self($userId, $purchaseHistory, $productAttributes));
    }

    public function recommends(): array
    {
        return [];
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getPurchaseHistory()
    {
        return $this->purchaseHistory;
    }

    public function getProductAttributes()
    {
        return $this->productAttributes;
    }
}
