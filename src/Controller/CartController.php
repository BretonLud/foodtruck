<?php

namespace App\Controller;

use App\Entity\Produits;
use App\Repository\ProduitsRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/order", name="order_")
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

        return $this->render('order/index.html.twig', compact("dataPanier", "total"));
    }
}