<?php

namespace App\Controller\Admin;


use App\Entity\User;
use App\Form\EditUserType;
use App\Repository\UserRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name="admin_")
 */
Class AdminController extends AbstractController{

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $em){

        $this->userRepository = $userRepository;
        $this->em = $em;
    }

    /**
     * @Route("/", name="index")
     */
    public function index(){

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * Liste les utilisateurs du site
     *
     * @Route("/utilisateurs", name="utilisateurs")
     */
    public function usersList(){
        return $this->render("admin/users/users.html.twig", [
            'users' => $this->userRepository->findAll()
        ]);
    }


    /**
     * Modifier un utilisateur
     *
     * @Route("/utilisateurs/modifier/{id}", name="modifier_utilisateurs")
     */
    public function editUser(User $user, Request $request)
    {
        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Utilisateur modifié avec succès');
            return $this->redirectToRoute('admin_utilisateurs');
        }

        return $this->render('admin/users/edituser.html.twig', [
            'userForm' => $form->createView()
        ]);
    }

    /**
     * @param User $user
     * @param Request $request
     * @return Response
     * @Route("/utilisateurs/delete/{id}", name="supprimer_utilisateurs")
     */
    public function delete(User $user, Request $request): Response
    {


        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->get('_token'))){

            $this->em->remove($user);
            $this->em->flush();
            $this->addFlash('success', 'Utilisateurs supprimé avec succès');

        }

        //return new Response('Suppression');
        return $this->redirectToRoute('admin_utilisateurs');
    }
}