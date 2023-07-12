<?php

namespace App\Controller;

use App\Form\ChoisirAdresseType;
use App\Form\ChoisirTransporteurType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ChoiceadresseController extends AbstractController
{
    #[Route('/compte/choisir/adresse', name: 'choisirAdresse')]
    public function index(): Response
    {
        $form = $this->createForm(ChoisirAdresseType::class,null,[
            'user' => $this->getUser()
        ]);
        return $this->render('choiceadresse/choisirAdresse.html.twig', [
            'f' => $form->createView(),
        ]);
    }
    #[Route('/compte/choisir/transporteur', name: 'choisirTransporteur')]
    public function choisirTransporteur(Request $request): Response
    {
        //objetif : récupérer les adresses choisies
        $adrL = null;
        $adrF = null;
        $formAdresse = $this->createForm(ChoisirAdresseType::class,null,[
            'user' => $this->getUser()
        ]);
        $formAdresse->handleRequest($request);
        if ( $formAdresse->isSubmitted() &&  $formAdresse->isValid()) { 
            //mettre l'adresse de livraison choisie dans la variable $adrl
            $adrL = $formAdresse->get('adresseLivraison')->getData();
            // mettre l'adresse de facturation choisie dans la variable $adrl
            $adrF = $formAdresse->get('adresseFacturation')->getData();
        }
        $form = $this->createForm(ChoisirTransporteurType::class);

        return $this->render('choiceAdresse/choisirTransporteur.html.twig',[
            'f' =>$form->createView(),
            'adrL' => $adrL,
            'adrF' => $adrF
        ]);
    }
}
