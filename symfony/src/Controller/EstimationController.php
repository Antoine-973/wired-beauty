<?php

namespace App\Controller;

use App\Entity\AccountRequest;
use App\Entity\ContactRequest;
use App\Entity\EstimationRequest;
use App\Form\AccountRequestType;
use App\Form\ContactType;
use App\Form\EstimationRequestType;
use App\Repository\AccountRequestRepository;
use App\Repository\EstimationRequestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/{_locale<%app.supported_locales%>}/estimation')]
class EstimationController extends AbstractController
{
    #[Route('', name: 'estimation_index', methods: ['GET', 'POST'])]
    public function index(Request $request, EstimationRequestRepository $estimationRepository): Response
    {
        $estimation = new EstimationRequest();
        $form = $this->createForm(EstimationRequestType::class, $estimation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $estimationRepository->add($estimation);
            return $this->redirectToRoute('estimation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('estimation/index.html.twig', [
            'form' => $form,
        ]);
    }
}
