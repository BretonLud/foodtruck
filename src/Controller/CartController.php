<?php

namespace App\Controller;

use App\Entity\OrderProduits;
use App\Entity\Produits;
use App\Repository\ProduitsRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/order", name="order_")
 * @IsGranted("ROLE_USER")
 */
class CartController extends AbstractController{


    public function ajaxAction(Request $request)
    {
        $test = $request->request->get("request");
        var_dump($test);
    }

    /**
     * @Route("/", name="index", methods="POST")
     */
    public function index(Request $request)
    {

        return $this->render('order/index.html.twig');
    }
}