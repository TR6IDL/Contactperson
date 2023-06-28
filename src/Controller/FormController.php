<?php

namespace App\Controller;

use App\Entity\Person;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class FormController extends AbstractController
{
    #[Route('', name: 'app_form')]
    public function index(Request $request,EntityManagerInterface $entityManager): Response
    {
        $person=new Person();
        $form=$this->createForm(ContactType::class, $person);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $name=$form->get('name')->getData();
            $email=$form->get('email')->getData();
            $message=$form->get('message')->getData();

            if($name=="" || $email=="" || $message==""){
                return new Response('Hiba! Kérjük töltsd ki az összes mezőt!');
            }
            else{
                return new Response('Köszönjük szépen a kérdésedet. Válaszunkkal hamarosan keresünk a megadott e-mail címen.');
            }
            

            $entityManager->persist($person);
            $entityManager->flush();
            
        }
        return $this->render('form/index.html.twig', [
            'our_form' => $form,
        ]);
    }
}
