<?php
namespace App\Classe;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class Panier
{
    // Préparer toutes les fonctions nécessaires 
    // pour gérer la session RequestStack
    private $emi;
    private $rs;
    public function __construct(EntityManagerInterface $emi, RequestStack $rs)
    {
        $this->emi = $emi;
        $this->rs = $rs;
    }
    public function ajouter($id){
        // Créer une sauvegarde vers le panier dans la session
        $panier = $this->rs->getSession()->get('panier', []);
        if(!empty($panier[$id])){
            // augmenter la quantité d'un article existant dans le panier
            $panier[$id]++;
        }else{
            // ajouter un nouveau article dans le panier
            $panier[$id] = 1;
        }
        $this->rs->getSession()->set('panier', $panier);
        /* 
        $this->rs->set('panier', [...])
        La structure de l'entrée 'panier' dans la session :
            panier [
                'id' =>  'qty' (par défaut la quantité commandée = 1)
            ]
        La structure du table 'panier' sous symfony :
            panier_twig [
                'product[]' =>  'qty' (par défaut la quantité commandée = 1)
            ]
        */
    }
    public function afficherTout() // convertir le panier de la session en une table pour l'affichage
    {
        $panier_twig = [];
        if($this->afficher()){ // le panier de la session n'est pas vide
            foreach($this->afficher() as $id => $qty){
                $obj = $this->emi->getRepository(Product::class)->find($id);
                if(!$obj){
                    $this->supprimer($id);
                    continue;
                }else{
                    $panier_twig[] = [
                        'product' => $obj,
                        'qty' => $qty
                    ];
                }
            }
            return $panier_twig;
        }   
    }
    public function afficher(){
        return $this->rs->getSession()->get('panier');
    }
    public function supprimer($id){
        // Créer une sauvegarde vers le panier dans la session
        $panier = $this->rs->getSession()->get('panier', []);
        unset($panier[$id]);
        $this->rs->getSession()->set('panier', $panier);
    }
    public function vider(){
        return $this->rs->getSession()->remove('panier');
    }
    public function reduire($id){
        // Créer une sauvegarde vers le panier dans la session
        $panier = $this->rs->getSession()->get('panier', []);
        if($panier[$id] == 1){
            unset($panier[$id]);
        }else{
            $panier[$id]--;
        }
        $this->rs->getSession()->set('panier', $panier);
    }
    public function nbArticles(){
        $nb = 0;
        if($this->afficher()){
            foreach($this->afficher() as $id => $qty){
                // $nb++; si vous voulez compter les différents articles
                // Si vous voulez compter les quantités :
                $nb += $qty;
                // $nb++;
            }
        }
        return $nb;
    }
}

?>