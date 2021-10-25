<?php

namespace App\Controller\Admin;

use App\Entity\Produits;
use App\Form\ProduitsType;
use App\Repository\ProduitsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name="admin_")
 */
class AdminProduitsController extends AbstractController
{
    /**
     * @var ProduitsRepository
     */
    private $repository;

    /**
     * @var EntityManagerInterface
     */
    private $em;


    public function __construct(ProduitsRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/produits/index", name="produits_index")
     * @return Response
     */
    public function index(): Response
    {
        $produits = $this->repository->findAll();
        return $this->render('admin/produits/index.html.twig', compact('produits'));
    }

    /**
     * @Route("/produits/create", name="produits_new")
     */
    public function new(Request $request)
    {
        $produit = new Produits();
        $form = $this->createForm(ProduitsType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $this->em->persist($produit);
            $this->em->flush();

            if($produit->getFilename() !== null ) {
                $path = '../public/images/produits/' . $produit->getFilename();
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                $produit->setBase64($base64);
                $this->em->flush();
                $this->addFlash('success', 'Bien créer avec succès');
                return $this->redirectToRoute('admin_produits_index');
            }
            return $this->redirectToRoute('admin_produits_index');
        }

        return $this->render('admin/produits/new.html.twig',[
            'produit' => $produit,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/produits/{id}", name="produits_edit", methods="GET|POST")
     */
    public function edit (Produits $produit, Request $request)
    {
        
        $form = $this->createForm(ProduitsType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $this->em->flush();
            if ($produit->getFilename() !== null) {
                $path = '../public/images/produits/' . $produit->getFilename();
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                $produit->setBase64($base64);
                $this->em->flush();
                $this->addFlash('success', 'Bien modifié avec succès');
                return $this->redirectToRoute('admin_produits_index');
            }
            else {
            
                $this->addFlash('error', 'Impossible d\'éditer le bien');
            }
       
            return $this->redirectToRoute('admin_produits_index');
        } 
        
        return $this->render('admin/produits/edit.html.twig',[
            'produit' => $produit,
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/produits/remove/{id}", name="produits_delete")
     */
    public function delete(Produits $produit, Request $request): Response
    {


        if ($this->isCsrfTokenValid('delete' . $produit->getId(), $request->get('_token'))){

            $this->em->remove($produit);
            $this->em->flush();
            $this->addFlash('success', 'Bien supprimé avec succès');

        }

        //return new Response('Suppression');
        return $this->redirectToRoute('admin_produits_index');
    }
}
