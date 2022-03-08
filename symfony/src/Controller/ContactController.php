<?php

namespace App\Controller;

use App\Entity\AccountRequest;
use App\Entity\ContactRequest;
use App\Form\AccountRequestType;
use App\Form\ContactType;
use App\Repository\AccountRequestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/contact')]
class ContactController extends AbstractController
{
    #[Route('/', name: 'app_contact_index', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        $contact = new ContactRequest();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dd($contact);
            return $this->redirectToRoute('app_contact_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contact/index.html.twig', [
            'form' => $form,
        ]);
    }
}
