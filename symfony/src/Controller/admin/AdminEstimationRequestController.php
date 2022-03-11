<?php

namespace App\Controller\admin;

use App\Entity\EstimationRequest;
use App\Form\EstimationRequest1Type;
use App\Repository\EstimationRequestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/estimation')]
class AdminEstimationRequestController extends AbstractController
{
    #[Route('/', name: 'app_admin_estimation_request_index', methods: ['GET'])]
    public function index(EstimationRequestRepository $estimationRequestRepository): Response
    {
        return $this->render('admin/estimation_request/index.html.twig', [
            'estimation_requests' => $estimationRequestRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_admin_estimation_request_show', methods: ['GET'])]
    public function show(EstimationRequest $estimationRequest): Response
    {
        return $this->render('admin/estimation_request/show.html.twig', [
            'estimation_request' => $estimationRequest,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_estimation_request_delete', methods: ['POST'])]
    public function delete(Request $request, EstimationRequest $estimationRequest, EstimationRequestRepository $estimationRequestRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$estimationRequest->getId(), $request->request->get('_token'))) {
            $estimationRequestRepository->remove($estimationRequest);
        }

        return $this->redirectToRoute('app_admin_estimation_request_index', [], Response::HTTP_SEE_OTHER);
    }
}
