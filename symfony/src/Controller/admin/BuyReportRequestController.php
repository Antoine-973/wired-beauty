<?php

namespace App\Controller\admin;

use App\Entity\BuyReportRequest;
use App\Form\BuyReportRequestType;
use App\Repository\BuyReportRequestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/{_locale<%app.supported_locales%>}/admin/buy-report-request')]
class BuyReportRequestController extends AbstractController
{
    #[Route('/', name: 'app_admin_buy_report_request_index', methods: ['GET'])]
    public function index(BuyReportRequestRepository $buyReportRequestRepository): Response
    {
        return $this->render('buy_report_request/index.html.twig', [
            'buy_report_requests' => $buyReportRequestRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_buy_report_request_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BuyReportRequestRepository $buyReportRequestRepository): Response
    {
        $buyReportRequest = new BuyReportRequest();
        $form = $this->createForm(BuyReportRequestType::class, $buyReportRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $buyReportRequestRepository->add($buyReportRequest);
            return $this->redirectToRoute('app_buy_report_request_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('buy_report_request/new.html.twig', [
            'buy_report_request' => $buyReportRequest,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_buy_report_request_show', methods: ['GET'])]
    public function show(BuyReportRequest $buyReportRequest): Response
    {
        return $this->render('buy_report_request/show.html.twig', [
            'buy_report_request' => $buyReportRequest,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_buy_report_request_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BuyReportRequest $buyReportRequest, BuyReportRequestRepository $buyReportRequestRepository): Response
    {
        $form = $this->createForm(BuyReportRequestType::class, $buyReportRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $buyReportRequestRepository->add($buyReportRequest);
            return $this->redirectToRoute('app_buy_report_request_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('buy_report_request/edit.html.twig', [
            'buy_report_request' => $buyReportRequest,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_buy_report_request_delete', methods: ['POST'])]
    public function delete(Request $request, BuyReportRequest $buyReportRequest, BuyReportRequestRepository $buyReportRequestRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$buyReportRequest->getId(), $request->request->get('_token'))) {
            $buyReportRequestRepository->remove($buyReportRequest);
        }

        return $this->redirectToRoute('app_buy_report_request_index', [], Response::HTTP_SEE_OTHER);
    }
}
