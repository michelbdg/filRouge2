<?php

namespace App\Controller;

use App\Classe\Panier;
use App\Form\ChoisirTransporteurType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RecapController extends AbstractController
{
    #[Route('/comte/recap/{adrL}/{adrF}', name: 'recap')]
    public function index($adrL, $adrF, Panier $panier, Request $request): Response
    {
        $transporteur = null;
        $formTransporteur = $this->createForm(ChoisirTransporteurType::class);
        $formTransporteur->handleRequest($request);
        if($formTransporteur->isSubmitted() && $formTransporteur->isValid()){
            $transporteur = $formTransporteur->get('transporteurs')->getData();
        }
        return $this->render('recap/recap.html.twig', [
            'adrL' => $adrL,
            'adrF' => $adrF,
            'panier' => $panier->afficherTout(),
            'transport' => $transporteur
        ]);
    }
}
