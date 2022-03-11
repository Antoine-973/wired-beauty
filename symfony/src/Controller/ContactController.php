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
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/{_locale<%app.supported_locales%>}/contact')]
class ContactController extends AbstractController
{
    #[Route('', name: 'contact_index', methods: ['GET', 'POST'])]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $contact = new ContactRequest();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $contactFormData = $form->getData();

            $message = (new Email())
                ->from($contactFormData->getEmail())
                ->to('contact@wired-beauty.com')
                ->subject($contactFormData->getSubject())
                ->text('Sender : '.$contactFormData->getEmail().\PHP_EOL.
                    'Fullname : '.$contactFormData->getFirstname().' '.$contactFormData->getLastname().\PHP_EOL.
                    'Phone : '.$contactFormData->getPhone().\PHP_EOL.
                    'Message : '.$contactFormData->getMessage(),
                    'text/plain');
            $mailer->send($message);

            $this->addFlash('success', 'Your message has been sent');

            return $this->redirectToRoute('contact_index');
        }

        return $this->renderForm('contact/index.html.twig', [
            'form' => $form,
        ]);
    }
}
