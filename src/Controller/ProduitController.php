<?php

namespace App\Controller;




use App\Entity\Produits;
use App\Repository\ProduitsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

Class ProduitController extends AbstractController{

    /**
     * @var ProduitsRepository
     */
    private ProduitsRepository $repository;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @param ProduitsRepository $repository
     * @param EntityManagerInterface $em
     */
    public function __construct(ProduitsRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }


    /**
     * @Route("/carte", name="produit")
     */
    public function index(Request $request) : Response
    {
        $produits =
            $this->repository->findAll();



        return $this->render('produit/index.html.twig', [
            'current_menu' => 'produits',
            'produits' => $produits
        ]);
    }

    /**
     * @Route("/produits/{slug}-{id}", name="produit_show", requirements={"slug": "[a-z0-9\-]*"})
     */
    public function show(Produits $produit, string $slug, Request $request):
Response {

        if ($produit->getSlug() !== $slug){
            return $this->redirectToRoute('property_show', [
                    'id' => $produit->getId(),
                    'slug' => $produit->getSlug()
                ], 301);
        }


        return $this->render('produit/show.html.twig', [
            'produit' => $produit,
            'current_menu' => 'properties',
        ]);
    }

    public function intentSecret(Produits $produits)
    {
        $intent = $this->stripeService->paymentIntent($produits);

        return $intent['client_secret'] ?? null;
    }

}