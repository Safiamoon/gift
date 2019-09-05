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
        return $this->render('index/accueil.html.twig', 
        
        );
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
        
                //TO DO: rediriger vers une page de confirmation
        }    

        return $this->render(
            'index/contact.html.twig',
            ['contactForm' => $form->createView()]
        
        );
    }
}
