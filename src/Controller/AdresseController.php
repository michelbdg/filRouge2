<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

namespace App\Controller;

use App\Entity\Adresse;
use App\Form\AdresseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdresseController extends AbstractController
{
    private $emi;
    public function __construct(EntityManagerInterface $emi)
    {
        $this->emi = $emi;
    }
    #[Route('/compte/adresse/ajouter', name: 'ajouterAdresse')]
    public function index(Request $request): Response
    {
        $adr = new Adresse();
        $form = $this->createForm(AdresseType::class, $adr);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            // récupérer l'utilisateur en cours(connecté)
            $currentUser = $this->getUser();
            // placer l'utilisateur en cours dans l'attribut user de l'adresse (SETTER)
            $adr->setUser($currentUser);
            $this->emi->persist($adr);
            $this->emi->flush();
           return $this->redirectToRoute('adresse');
        }
        return $this->render('adresse/gestionAdresse.html.twig', [
            'formAdresse' => $form->createView(),
            'titre' => "Ajouter une nouvelle adresse"
        ]);
    }
    #[Route('/compte/adresse', name: 'adresse')]
    public function index1(): Response
    {
        return $this->render('adresse/mesAdresses.html.twig');
    }
    #[Route('/compte/adresse/supprimer/{id}', name: 'supprimerAdresse')]
    public function index2($id): Response
    {
        // Injection de dépendance via une route de la variable $id
        $adr = $this->emi->getRepository(Adresse::class)->find($id);
        // vérifier si l'adresse existe et l'utilisateur en cours est son proprio.
        if($adr && ($this->getUser() == $adr->getUser())){
            $this->emi->remove($adr);
            $this->emi->flush();
        }
        return $this->redirectToRoute('adresse');
    }
    #[Route('/compte/adresse/modifier/{id}', name: 'modifierAdresse')]
    public function index3($id, Request $request): Response
    {
        // Injection de dépendance via une route de la variable $id
        $adr = $this->emi->getRepository(Adresse::class)->find($id);
        if(!$adr || ($this->getUser() != $adr->getUser())){
            return $this->redirectToRoute('adresse');
        }
        $form = $this->createForm(AdresseType::class, $adr);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->emi->flush();
            return $this->redirectToRoute('adresse');
        }
        return $this->render('adresse/gestionAdresse.html.twig', [
            'formAdresse' => $form->createView(),
            'titre' => "Modifier votre adresse"
        ]);
    }
}
