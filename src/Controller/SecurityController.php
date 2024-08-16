<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
  #[Route('/logout', name: 'app_logout')]
  public function logout(Security $security): never
  {
    $security->logout();

    $security->logout(validateCsrfToken: false);

    throw new \Exception('You should not be here!');
  }
}
