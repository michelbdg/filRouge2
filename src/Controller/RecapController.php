<?php

namespace App\Controller;

use App\Classe\Panier;
use App\Entity\Commande;
use App\Entity\CommandeLigne;
use App\Form\ChoisirTransporteurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RecapController extends AbstractController
{
    private $emi;
    public function __construct(EntityManagerInterface $emi)
    {
        $this->emi = $emi;
    }
    #[Route('/comte/recap/{adrL}/{adrF}', name: 'recap')]
    public function index($adrL, $adrF, Panier $panier, Request $request): Response
    {
        $transporteur = null;
        $formTransporteur = $this->createForm(ChoisirTransporteurType::class);
        $formTransporteur->handleRequest($request);
        if($formTransporteur->isSubmitted() && $formTransporteur->isValid()){
            $transporteur = $formTransporteur->get('transporteur')->getData();
            // préparation des données
            $date = new \DateTimeImmutable();
            $reference = $date->format('dmY').'-'.uniqid();

            // Préparation de la commande
            $commande = new Commande();
            $commande->setAdrLivraison($adrL);
            $commande->setAdrFacturation($adrF);
            $commande->setUser($this->getUser());
            $commande->setCreateAt($date);
            $commande->setReference($reference);
            $commande->setTransporteurSociete($transporteur->getSociete());
            $commande->setTprix($transporteur->getPrice());
            $commande->setIsfinalized(0);
            $this->emi->persist($commande);
            //Préparation des lignes de commandes
            foreach($panier->afficherTout() as $product){
                //Créer un objet vide de Commande Ligne
                $cmdLigne = new CommandeLigne();
                $cmdLigne->setCommande($commande);
                $cmdLigne->setProductName($product['product']->getName());
                $cmdLigne->setProductQuantity($product['qty']);
                $cmdLigne->setProductPrice($product['product']->getPrice() / 100);
                $cmdLigne->setTotal(($product['product']->getPrice() / 100) * ($product['qty']));
                $this->emi->persist($cmdLigne);
            }
            $this->emi->flush();
        }
        return $this->render('recap/recap.html.twig', [
            'adrL' => $adrL,
            'adrF' => $adrF,
            'panier' => $panier->afficherTout(),
            'transport' => $transporteur,
            'reference' => $reference
        ]);
    }
}
