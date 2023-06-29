<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\InscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionController extends AbstractController
{
    private $emi;
    public function __construct(EntityManagerInterface $emi)
    {
        $this->emi = $emi;
    }
    #[Route('/inscription', name: 'app_inscription')]
    public function index(Request $request,UserPasswordHasherInterface $uphi): Response
    {
        $user = new User();
        $form = $this->createForm(InscriptionType::class,$user);
            // Ecouter la soumission du formulaire
         $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $password = $user->getPassword();
            // Permet de cryptée le mot de passe dans la base de données
            $hashedPassword = $uphi->hashPassword($user,$password);
            $user->setPassword($hashedPassword);
            //dd($user);
            $this->emi->persist($user);
            $this->emi->flush();
        }
        return $this->render('inscription/Inscription.html.twig', [
            'formInscription' => $form->createView()
        ]);
    }
}
