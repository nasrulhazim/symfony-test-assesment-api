<?php

namespace App\Processors\Recommendation;

use MathPHP\LinearAlgebra\Vector;
use MathPHP\Statistics\Distance;

class Collaborative extends Base
{
    public function recommends(): array
    {
        $userId = $this->getUserId();
        $purchaseHistory = $this->getPurchaseHistory();
        $similarities = [];
        $userPurchases = $purchaseHistory[$userId] ?? [];

        foreach ($purchaseHistory as $otherUserId => $otherUserPurchases) {
            if ($userId === $otherUserId) {
                continue;
            }

            $similarity = $this->calculateCosineSimilarity($userPurchases, $otherUserPurchases);
            $similarities[$otherUserId] = $similarity;
        }

        // Sort users by similarity
        arsort($similarities);

        // Get top N similar users
        $topUsers = array_slice($similarities, 0, 5, true);

        // Generate recommendations based on top users' purchases
        $recommendations = [];

        foreach ($topUsers as $otherUserId => $similarity) {
            foreach ($purchaseHistory[$otherUserId] as $productId => $quantity) {
                if (!isset($userPurchases[$productId])) {
                    if (!isset($recommendations[$productId])) {
                        $recommendations[$productId] = 0;
                    }
                    $recommendations[$productId] += $quantity * $similarity;
                }
            }
        }

        // Sort recommendations by score
        arsort($recommendations);

        return array_keys($recommendations);
    }

    private function calculateCosineSimilarity(array $user1, array $user2)
    {
        $user1Vector = new Vector(array_values($user1));
        $user2Vector = new Vector(array_values($user2));

        return Distance::cosineSimilarity($user1Vector->getVector(), $user2Vector->getVector());
    }
}
