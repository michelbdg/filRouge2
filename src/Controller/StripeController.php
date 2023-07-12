<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StripeController extends AbstractController
{
    #[Route('/stripe', name: 'stripe')]
    public function index(): Response
    {
        return $this->render('stripe/stripe.html.twig', [
            'controller_name' => 'StripeController',
        ]);
    }
}
