<?php

namespace App\Controller;

use App\Repository\ProduitsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController{

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/", name="indexpage")
     */
    public function index (ProduitsRepository $repository){

        $produits = $repository->findLatest();
        return $this->render('pages/home.html.twig', [
            'produits' => $produits
        ]);
    }
}