<?php

namespace App\Controller;

use App\Form\ContactType;
use Doctrine\DBAL\Schema\View;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Contact;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function accueil()
    {
        return $this->render('index/accueil.html.twig',);
    }


/**
 * 
 *@Route("/contact", name="contact")
 *
 */
public function contact(Request $request) 
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();     

                //Ajout d'un message à la session
                $this->addFlash(
                    "Success",
                    "Votre message a été envoyé, merci."
                );
                //Redirection vers une page affichant les messsages flash
                return $this->redirectToRoute('display_flash');
        }    

        return $this->render(
            'index/contact.html.twig',
            ['contactForm' => $form->createView()]
        
        );
    }
    /**
     *@Route("/display/message", name="display_flash")
     */
    public function flash()
        {
            return $this->render("index/flash.html.twig");

        }
}
