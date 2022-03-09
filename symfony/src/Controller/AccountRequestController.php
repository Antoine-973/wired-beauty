<?php

namespace App\Controller;

use App\Entity\AccountRequest;
use App\Form\AccountRequestType;
use App\Repository\AccountRequestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/join')]
class AccountRequestController extends AbstractController
{
    #[Route('/professionals', name: 'account_request_pro_index', methods: ['GET', 'POST'])]
    public function pro_index(Request $request, AccountRequestRepository $accountRequestRepository): Response
    {
        $accountRequest = new AccountRequest();
        $form = $this->createForm(AccountRequestType::class, $accountRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $accountRequest->setType("PRO");
            $accountRequestRepository->add($accountRequest);
            return $this->redirectToRoute('account_request_pro_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('account_request/professionals.html.twig', [
            'account_request' => $accountRequest,
            'form' => $form,
        ]);
    }

    #[Route('/scientists', name: 'account_request_scientists_index', methods: ['GET', 'POST'])]
    public function scientists_index(Request $request, AccountRequestRepository $accountRequestRepository): Response
    {
        $accountRequest = new AccountRequest();
        $form = $this->createForm(AccountRequestType::class, $accountRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $accountRequest->setType("SCIENTIST");
            $accountRequestRepository->add($accountRequest);
            return $this->redirectToRoute('account_request_scientists_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('account_request/scientists.html.twig', [
            'account_request' => $accountRequest,
            'form' => $form,
        ]);
    }

    #[Route('/panelists', name: 'account_request_panelists_index', methods: ['GET', 'POST'])]
    public function panelists_index(Request $request, AccountRequestRepository $accountRequestRepository): Response
    {
        $accountRequest = new AccountRequest();
        $form = $this->createForm(AccountRequestType::class, $accountRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $accountRequest->setType("PANELISTS");
            $accountRequestRepository->add($accountRequest);
            return $this->redirectToRoute('account_request_panelists_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('account_request/panelists.html.twig', [
            'account_request' => $accountRequest,
            'form' => $form,
        ]);
    }
}
