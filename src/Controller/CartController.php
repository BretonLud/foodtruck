<?php

namespace App\Controller;

use App\Entity\Produits;
use App\Repository\ProduitsRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cart", name="cart_")
 * @IsGranted("ROLE_USER")
 */
class CartController extends AbstractController{

    /**
     * @Route("/", name="index")
     */
    public function index(SessionInterface $session, ProduitsRepository $produitsRepository)
    {
        $panier = $session->get("panier", []);

        //On "fabrique" les données
        $dataPanier = [];
        $total = 0;

        foreach ($panier as $id => $quantite){
            $produits = $produitsRepository->find($id);
            $dataPanier[] = [
                'produit' => $produits,
                'quantite' => $quantite,
            ];
            $total += $produits->getPrix() * $quantite;
        }

        return $this->render('cart/index.html.twig', compact("dataPanier", "total"));
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

    /**
     * @Route("/remove/{id}", name="remove")
     */
    public function remove(Produits $produits, SessionInterface $session)
    {
        //on récupère le panier actuel
        $panier = $session->get("panier", []);
        $id = $produits->getId();

        if (!empty($panier[$id])) {
            if ($panier[$id] > 1) {
                $panier[$id]--;
            } else {
                unset($panier[$id]);
            }
        }

        // On sauvegarde dans la session
        $session->set("panier", $panier);

        return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(Produits $produits, SessionInterface $session)
    {
        //on récupère le panier actuel
        $panier = $session->get("panier", []);
        $id = $produits->getId();

        if (!empty($panier[$id])) {
                unset($panier[$id]);
        }

        // On sauvegarde dans la session
        $session->set("panier", $panier);

        return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/delete", name="delete_all")
     */
    public function delete_all( SessionInterface $session)
    {

        $session->remove("panier");

        return $this->redirectToRoute("cart_index");
    }


}