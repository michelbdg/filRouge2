<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeliciousController extends AbstractController
{
    #[Route('/delicious', name: 'app_delicious')]
    public function index(): Response
    {
        return $this->render('delicious/index.html.twig', [
            'controller_name' => 'DeliciousController',[
                $name = "michel"
            ]
        ]);
    }
}
