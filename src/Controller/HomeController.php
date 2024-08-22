<?php

namespace App\Controller;

use App\Entity\Customer\Books;
use Doctrine\Persistence\ManagerRegistry;
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

    #[Route('/books', name: 'app_books')]
    public function books(ManagerRegistry $doctrine): Response
    {   
        $customerEntityManager = $doctrine->getManager('customer');
        $books = $customerEntityManager->getRepository(Books::class)->findAll();
        dd($books);

        return $this->render('fiscal/index.html.twig', [
        ]);
    }
}
