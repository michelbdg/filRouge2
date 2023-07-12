<?php
 
namespace App\Controller;
 
use Stripe\Stripe;
use App\Entity\Product;
use App\Entity\Commande;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Checkout\Session;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
 
class StripeController extends AbstractController
{
    private $emi;
    public function __construct(EntityManagerInterface $emi)
    {
       $this->emi = $emi; 
    }
    #[Route('/commande/create-session/{reference}', name: 'stripe_create_session')]
    public function index($reference): Response
    {
        $ref = str_replace('%20','',$reference);
        $sessionProducts = []; // on va sauvegarder les produits de notre commande
 
        $YOUR_DOMAIN = "http://127.0.0.1:8000";
        $commande = $this->emi->getRepository(Commande::class)->findOneBy(['reference' => $reference]);
        // Remplir le tableau sessionProducts
        foreach($commande->getCommandeLignes()->getValues() as $product){
            $prod = $this->emi->getRepository(Product::class)
            ->findOneBy(['name' => $product->getProductName()]);
            $sessionProducts[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $product->getProductPrice() * 100,
                    'product_data' => [
                        'name' => $product->getProductName(),
                        'images' => ["images/products/".$prod->getImage()]
                    ]
                ],
                'quantity' => $product->getProductQuantite()
            ];
        }
        // Ajouter les frais de livraison
        $sessionProducts[] = [
            'price_data' => [
                'currency' => 'eur',
                'unit_amount' => $commande->getTprix() * 100,
                'product_data' => [
                    'name' => $commande->getTsociete(),
                    'images' => [$YOUR_DOMAIN]
                ]
            ],
            'quantity' => 1
        ];
        // Utilisation de la clé secrète
        Stripe::setApiKey('sk_test_51KSV1UBy1MEUEfBYIYeUmjvDaofu6WKjB18Aq3mFAePFC1giO17ag3JSxO8IgkKczP710an5ftXffwcTFH2FA3kt00wBr1EE1Q');
        // Création de la session checkout
        $checkout_session = Session::create([
            'customer_email' => $this->getUser()->getEmail(),
            'payment_method_types' => ['card'],
            'line_items' => [$sessionProducts],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . "/commande/success/{CHECKOUT_SESSION_ID}",
            'cancel_url' => $YOUR_DOMAIN . "/cancel.html"
        ]);
        $sessionId = $checkout_session->id;
        $commande->setStripeId($sessionId);
        $this->emi->flush();
 
        $response = new JsonResponse(['id' => $sessionId]);
        return $response;
 
    }
}
?>