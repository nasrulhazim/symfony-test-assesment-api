<?php

namespace App\Processors\Recommendation;

use MathPHP\LinearAlgebra\Vector;

class Content extends Base
{

    public function recommends(): array
    {
        $userId = $this->getUserId();
        $purchaseHistory = $this->getPurchaseHistory();

        $userPurchases = $purchaseHistory[$userId] ?? [];
        $productAttributes = $this->getProductAttributes();

        // Calculate the user's profile vector based on purchased products
        $userProfile = $this->calculateUserProfile($userPurchases, $productAttributes);

        // Calculate similarity of each product to the user's profile
        $similarities = [];

        foreach ($productAttributes as $productId => $attributes) {
            $productVector = new Vector(array_values($attributes));
            $similarity = $userProfile->cosineSimilarity($productVector);
            $similarities[$productId] = $similarity;
        }

        // Sort products by similarity
        arsort($similarities);

        // Filter out products the user has already purchased
        $recommendations = array_diff_key($similarities, $userPurchases);

        return array_keys($recommendations);
    }

    private function calculateUserProfile(array $userPurchases, array $productAttributes)
    {
        $profile = [];

        foreach ($userPurchases as $productId => $quantity) {
            $attributes = $productAttributes[$productId] ?? [];

            foreach ($attributes as $key => $value) {
                if (!isset($profile[$key])) {
                    $profile[$key] = 0;
                }
                $profile[$key] += $value * $quantity;
            }
        }

        return new Vector(array_values($profile));
    }
}
