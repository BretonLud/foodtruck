<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Produits;
use App\Entity\OrderProduits;
use App\Entity\User;
use App\Repository\OrderProduitsRepository;
use App\Service\Stripe;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/order", name="order_")
 * @IsGranted("ROLE_USER")
 */
class CartController extends AbstractController{

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var Stripe
     */
    private $stripe;

    public function __construct(EntityManagerInterface $em, Stripe $stripe)
    {
        $this->em = $em;
        $this->stripe = $stripe;
    }

    /**
     * @Route("/", name="index")
     * @param Request $request
     */
    public function index(SessionInterface $session)
    {

        $sessionCommand =  $session->get("command");
        $sessionProduits = $session->get("products");

        return $this->render('order/index.html.twig', [
            'order' => $sessionCommand,
            'produits' => $sessionProduits
        ], $session->clear() );
    }

    /**
     * @param SessionInterface $session
     * @param Request $request
     * @Route("/paiement", name="paiement")
     */
    public function ajaxRequest(SessionInterface $session, Request $request)
    {
        $datas = json_decode($request->getContent(), true);



        if(!empty($datas)) {

            $user = $this->getUser();
            $price = $datas['PrixTotal'];
            $ressource = [
                'stripeBrand' =>  $datas['StripeToken']['card']['brand'],
                'stripeLast4' =>  $datas['StripeToken']['card']['last4'],
                'stripeID'  =>  $datas['StripeToken']['id'],
            ];
            $order = new Order();
            $order->setUser($user);
            $order->setPrice($price);
            $order->setReference(uniqid('', false));
            $order->setBrandStripe($ressource['stripeBrand']);
            $order->setLast4Stripe($ressource['stripeLast4']);
            $order->setIdChargeStripe($ressource['stripeID']);
            $order->setCreatedAt(new \Datetime());
            $this->em->persist($order);
            $this->em->flush();

            $product = [];

            foreach (json_decode($datas['Produits'], true) as $produit) {
                $name =  $this->getDoctrine()
                    ->getRepository(Produits::class)
                    ->find($produit['id']);
                $qty = $produit['qty'];

                $command = new OrderProduits();
                $command->setCommand($order);
                $command->setProduits($name);
                $command->setQuantity($qty);
                $this->em->persist($command);
                $this->em->flush();

                $product[] = [
                    'quantite' => $command->getQuantity(),
                    'produit' => $command->getProduits()];
            }

            $session->set("command", $order);
            $session->set("products", $product);
        }

        return $this->render('order/index.html.twig');
    }
}