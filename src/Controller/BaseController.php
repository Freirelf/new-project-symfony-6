<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Translation\LocaleSwitcher;

class BaseController extends AbstractController
{   
    protected $session;

    public function __construct(private LocaleSwitcher $localeSwitcher) 
    {
        $this->session = new Session();
        $this->localeSwitcher->setLocale($this->session->get('idioma', 'en'));

    }
}
