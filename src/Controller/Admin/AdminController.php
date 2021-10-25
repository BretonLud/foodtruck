<?php

namespace App\Controller\Admin;


use App\Entity\User;
use App\Form\EditUserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name="admin_")
 */
Class AdminController extends AbstractController{

    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository){

        $this->userRepository = $userRepository;

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
        $admin = $user->getRoles();

        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('message', 'Utilisateur modifié avec succès');
            return $this->redirectToRoute('admin_utilisateurs');
        }

        return $this->render('admin/users/edituser.html.twig', [
            'userForm' => $form->createView()
        ]);
    }
}