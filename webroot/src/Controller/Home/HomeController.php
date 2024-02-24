<?php

namespace App\Controller\Home;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home_action')]
    public function homeAction(): Response
    {
        var_dump('ok');
        return $this->render('home/home.html.twig');
    }

    #[Route('/logged', name: 'app_logged_action')]
    public function loggedAction(): Response
    {
        return $this->render('home/logged.html.twig');
    }
}
