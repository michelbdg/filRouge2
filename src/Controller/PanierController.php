<?php

namespace App\Controller;

use App\Classe\Panier;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'panier')]
    public function index(Panier $panier): Response
    {
        return $this->render('panier/panier.html.twig', [
            'panier' => $panier->afficherTout(),
        ]);
    }
    #[Route('/panier/ajouter/{id}', name: 'ajouterPanier')]
    public function ajouterPanier(Panier $panier, $id): Response
    {
        $panier->ajouter($id);
        return $this->redirectToRoute('panier');
    }
    #[Route('/panier/reduire/{id}', name: 'reduirePanier')]
    public function reduirePanier(Panier $panier, $id): Response
    {
        $panier->reduire($id);
        return $this->redirectToRoute('panier');
    }
    #[Route('/panier/supprimer/{id}', name: 'supprimerPanier')]
    public function supprimerPanier(Panier $panier, $id): Response
    {
        $panier->supprimer($id);
        return $this->redirectToRoute('panier');
    }
    #[Route('/panier/vider', name: 'viderPanier')]
    public function viderPanier(Panier $panier): Response
    {
        $panier->vider();
        return $this->redirectToRoute('panier');
    }
}
