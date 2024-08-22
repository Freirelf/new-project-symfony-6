<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Translation\LocaleSwitcher;

class LangaugeController extends AbstractController
{
    #[Route('admin/langauge/{idioma}', name: 'app_langauge')]
    public function index($idioma, LocaleSwitcher $localeSwitcher, Session $session): Response
    {   
        $session->set('idioma', $idioma);
        // $localeSwitcher->setLocale($idioma);
        return $this->redirectToRoute('app_admin');
    }
}
