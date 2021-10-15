<?php

namespace App\Controller;

use App\Form\EditProfileType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;


/**
 * @Route("/profil", name="profil_")
 */
class ProfilController extends AbstractController
{
    /**
     * @return Response
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->render('profil/index.html.twig');
    }

    /**
     * @Route("/modifier", name="modifier")
     */
    public function editProfile(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(EditProfileType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('message','Profil mis à jour');
            return $this->redirectToRoute('profil_index');
        }

        return $this->render('profil/editprofile.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @Route("/pass/modifier", name="pass")
     */
    public function editPass(Request $request, UserPasswordHasherInterface $passwordHasher
                            ) : Response

    {

        if($request->isMethod('POST')){
            $em = $this->getDoctrine()->getManager();

            $user = $this->getUser();
            $mdp = $request->request->get('pass');
            $mdp2 = $request->request->get('pass2');
            $old_mdp = $request->request->get('old_mdp');

            if(!empty($old_mdp) && $passwordHasher->isPasswordValid($user , $old_mdp) === true) {
                // on vérifie si les 2 mots de passe sont identiques

                if (!empty($mdp) && !empty($mdp2)) {
                    if ($mdp == $mdp2) {
                        if (strlen($mdp) >= 8) {
                            $user->setPassword($passwordHasher->hashPassword($user, $mdp));
                            $em->flush();
                            $this->addFlash('message', 'Mot de passe mis a jour avec succès');

                            return $this->redirectToRoute('profil_index');
                        } else {
                            $this->addFlash('error','Le mot de passe doit faire 8 caractères minimum');
                        }
                    } else {
                        $this->addFlash('error', 'Les deux mots de passe ne sont pas identiques');
                    }
                } else {
                    $this->addFlash('error','Merci de completer tous les champs' );
                }
            } else {
                $this->addFlash('error', 'Mot de passe actuel erroné');
            }
        }
        return $this->render('profil/editpass.html.twig');
    }

    /*/**
     * @Route("/password", name="password)
     */
    /*public function changePassword() {

    }*/
}