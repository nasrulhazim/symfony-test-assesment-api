<?php

namespace App\Processors;

use App\Entity\Order;
use App\Entity\OrderProduct;
use App\Entity\Product;
use App\Processors\Recommendation\Collaborative;
use App\Processors\Recommendation\Content;
use App\Processors\Recommendation\Hybrid;
use Doctrine\ORM\EntityManagerInterface;

class RecommendationProcessor
{
    /**
     * Entity manager.
     */
    private $em;

    /**
     * The current user to be compare with.
     */
    private $userId;

    public function __construct(EntityManagerInterface $em, $userId)
    {
        $this->em = $em;
        $this->userId = $userId;
    }

    /**
     * Get Purchase Histories
     *
     * @return array
     */
    public function getPurchaseHistory(): array
    {
        $orders = $this->em->getRepository(Order::class)->findAll();
        $purchaseHistory = [];

        foreach ($orders as $order) {
            $orderProducts = $order->getOrderProducts();

            foreach ($orderProducts as $orderProduct) {
                $user = $order->getUser();
                $productId = $orderProduct->getProduct()->getId();
                $quantity = $orderProduct->getQuantity();

                if (!isset($purchaseHistory[$user])) {
                    $purchaseHistory[$user] = [];
                }

                if (!isset($purchaseHistory[$user][$productId])) {
                    $purchaseHistory[$user][$productId] = 0;
                }

                $purchaseHistory[$user][$productId] += $quantity;
            }
        }

        return $purchaseHistory;
    }

    /**
     * Get Product Attributes
     *
     * @return array
     */
    public function getProductAttributes(): array
    {
        $products = $this->em->getRepository(Product::class)->findAll();
        $productAttributes = [];

        foreach ($products as $product) {
            $productId = $product->getId();
            $productAttributes[$productId] = [
                'category' => $product->getCategory(),
                'price' => $product->getPrice(),
                'brand' => $product->getBrand(),
                'size' => $product->getSize(),
                'color' => $product->getColor(),
            ];
        }

        return $productAttributes;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function recommend(string $type)
    {
        return match ($type) {
             'collaborative' => Collaborative::make($this->getUserId(), $this->getPurchaseHistory(), $this->getProductAttributes()),
             'content' => Content::make($this->getUserId(), $this->getPurchaseHistory(), $this->getProductAttributes()),
             default => Hybrid::make($this->getUserId(), $this->getPurchaseHistory(), $this->getProductAttributes()),
        };
    }
}
