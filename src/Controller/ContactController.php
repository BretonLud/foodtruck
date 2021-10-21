<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Notification\ContactNotification;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/contact", name="contact_")
 */
 class ContactController extends AbstractController{

     /**
      * @Route("/", name="index")
      */
    public function index(Request $request, ContactNotification $notification)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $notification->notify($contact);
            $this->addFlash('success', 'Votre email a bien été envoyé, nous vous répondrons dans les plus bref délais');
            return $this->redirectToRoute('contact_index');
        } else if ($form->isSubmitted() && !$form->isValid() ){
            $this->addFlash('error', 'Votre email n\'a pas pu être envoyé');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}