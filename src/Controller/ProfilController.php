<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderProduits;
use App\Entity\User;
use App\Form\EditProfileType;
use App\Repository\OrderProduitsRepository;
use App\Repository\OrderRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/profil", name="profil_")
 */
class ProfilController extends AbstractController
{

    /**
     * @var OrderRepository
     */
    private  $orderRepository;

    /**
     * @var OrderProduitsRepository
     */
    private $orderProduitsRepository;

    /**
     * @param OrderRepository $orderRepository
     * @param OrderProduitsRepository $orderProduitsRepository
     */
    public function __construct(OrderRepository $orderRepository, OrderProduitsRepository $orderProduitsRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->orderProduitsRepository = $orderProduitsRepository;
    }

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
     * @param UserPasswordHasherInterface $passwordHasher
     * @return Response
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
                        $pattern = '((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W]).{8,64})';
                        if(preg_match($pattern, $mdp)) {
                            if (strlen($mdp) >= 8) {
                                $user->setPassword($passwordHasher->hashPassword($user, $mdp));
                                $em->flush();
                                $this->addFlash('message', 'Mot de passe mis a jour avec succès');

                                return $this->redirectToRoute('profil_index');
                            } else {
                                $this->addFlash('error', 'Le mot de passe doit faire 8 caractères minimum');
                            }
                        } else {
                            $this->addFlash('error', 'Le mot de passe doit contenir 1 majuscule, 1 chiffre et 1 caractère spécial');
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

    /**
     * @return Response
     * @Route("/history", name="history")
     */
    public function history(PaginatorInterface $paginator, Request $request): Response
    {
        $user = $this->getUser();

        $orders = $this->orderRepository->findByUser($user);



            /*$pagination = $paginator->paginate(
                $orders,
                $request->query->getInt('page', 1),
                4
            );*/



       return $this->render('profil/history.html.twig', [
           'commandes' => $orders/*$pagination*/
       ]);
    }

}