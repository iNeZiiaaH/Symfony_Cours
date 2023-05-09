<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    #[Route('/api/article', name: 'app_api_article')]
    public function index(): Response
    {
        return $this->render('api/article/index.html.twig', [
            'controller_name' => 'ArticleController',
        ]);
    }
}
