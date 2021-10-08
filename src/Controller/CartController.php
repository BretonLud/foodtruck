<?php

namespace App\Controller;

use App\Entity\Produits;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cart", name="cart_")
 */
class CartController extends AbstractController{

    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('cart/index.html.twig', []);
    }

    /**
     * @Route("/add/{id}", name="add")
     */
    public function add(Produits $produits, SessionInterface $session)
    {
        //on récupère le panier actuel
        $panier = $session->get("panier", []);
        $id = $produits->getId();

        if (!empty($panier[$id])){
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }

        // On sauvegarde dans la session
        $session->set("panier", $panier);

        return $this->redirectToRoute("cart_index");
    }
}