<?php

namespace App\Controller;

use App\Repository\NewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class NewsController extends AbstractController
{
    #[Route('/admin/news', name: 'app_news')]
    public function index(NewsRepository $newsRepository): Response
    {
        $entities = $newsRepository->findAll();
        return $this->render('news/index.html.twig', [
            'entities' => $entities,
            'activeMenu' => 'news',
        ]);
    }
}
