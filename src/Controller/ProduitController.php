<?php

namespace App\Controller;



use App\Entity\Order;
use App\Entity\Produits;
use App\Entity\User;
use App\Repository\ProduitsRepository;
use App\Service\Stripe;
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
     * @var Stripe
     */
    protected $stripeService;

    /**
     * @param ProduitsRepository $repository
     * @param EntityManagerInterface $em
     */
    public function __construct(ProduitsRepository $repository, EntityManagerInterface $em, Stripe $stripeService)
    {
        $this->repository = $repository;
        $this->em = $em;
        $this->stripeService = $stripeService;
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