<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {   
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        return $this->render('home/index.html.twig', [
        ]);
    }

    #[Route('/fiscal', name: 'app_fiscal')]
    public function fiscal(): Response
    {   
        return $this->render('fiscal/index.html.twig', [
        ]);
    }
}
