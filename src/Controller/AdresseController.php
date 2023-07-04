<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdresseController extends AbstractController
{
    #[Route('/adresse', name: 'adresse')]
    public function index(): Response
    {
        return $this->render('adresse/adresse.html.twig', [
            'controller_name' => 'AdresseController',
        ]);
    }
}
