<?php

namespace App\Controller\Api;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

class ArticleController extends AbstractController
{
    #[Route('/api/articles', name: 'app_api_article')]
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();
        return $this->json(
            $articles,
            context: ['groups' => 'articles:read',
            DateTimeNormalizer::FORMAT_KEY => 'd/m/Y']
        );
    }
}
