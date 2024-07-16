<?php

namespace App\Processors\Recommendation;


class Hybrid extends Base
{
    public function recommends(): array
    {
        $userId = $this->getUserId();
        $purchaseHistory = $this->getPurchaseHistory();
        $productAttributes = $this->getProductAttributes();

        $collaborativeRecommendations = Collaborative::make($userId, $purchaseHistory, $productAttributes);
        $contentBasedRecommendations = Content::make($userId, $purchaseHistory, $productAttributes);

        // Combine recommendations using a weighted sum
        $recommendationScores = [];

        foreach ($collaborativeRecommendations as $productId) {
            if (!isset($recommendationScores[$productId])) {
                $recommendationScores[$productId] = 0;
            }
            $recommendationScores[$productId] += 0.5; // weight for collaborative filtering
        }

        foreach ($contentBasedRecommendations as $productId) {
            if (!isset($recommendationScores[$productId])) {
                $recommendationScores[$productId] = 0;
            }
            $recommendationScores[$productId] += 0.5; // weight for content-based filtering
        }

        // Sort products by combined scores
        arsort($recommendationScores);

        return array_keys($recommendationScores);
    }
}
