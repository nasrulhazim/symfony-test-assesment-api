<?php

namespace App\Controller;

use App\Entity\User;
use App\Processors\RecommendationProcessor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[Route('/api', name: 'api_')]
class RecommendationController extends AbstractController
{
    #[Route('/recommendations', name: 'app_recommendations', methods: ['GET'])]
    public function index(Request $request, #[CurrentUser] User $user, RecommendationProcessor $recommendationProcessor): JsonResponse
    {
        $recommendationProcessor->setUserId($user->getId());

        $recommendations = $recommendationProcessor->recommend($request->get('type', 'hybrid'));

        return $this->json([
            'data' => $recommendations,
        ]);
    }
}
