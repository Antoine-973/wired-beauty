<?php

namespace App\Controller\admin;

use App\Entity\BuyReportRequest;
use App\Form\BuyReportRequestType;
use App\Repository\BuyReportRequestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/{_locale<%app.supported_locales%>}/admin/buy-report-request')]
class BuyReportRequestController extends AbstractController
{
    #[Route('/', name: 'app_admin_buy_report_request_index', methods: ['GET'])]
    public function index(BuyReportRequestRepository $buyReportRequestRepository, Request $request): Response
    {
        $param = $request->query->get('accepted');

        if( in_array($param, ['accepted', 'false']) ){
            $results = $buyReportRequestRepository->findBy(['accepted' => $param]);
        }else{
            $results = $buyReportRequestRepository->findAll();
        }

        return $this->render('admin/buy_report_request/index.html.twig', [
            'buy_report_requests' => $results,
        ]);
    }

    #[Route('/accept/{id}', name: 'app_admin_buy_report_request_accept', methods: ['GET'])]
    public function accept(BuyReportRequest $buyReportRequest, EntityManagerInterface $entityManager): Response
    {
        $buyReportRequest->setAccepted(true);
        $entityManager->flush();

        return $this->redirectToRoute('app_admin_buy_report_request_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/deny/{id}', name: 'app_admin_buy_report_request_deny', methods: ['GET'])]
    public function deny( BuyReportRequest $buyReportRequest, BuyReportRequestRepository $buyReportRequestRepository): Response
    {
        $buyReportRequestRepository->remove($buyReportRequest);
        return $this->redirectToRoute('app_admin_buy_report_request_index', [], Response::HTTP_SEE_OTHER);
    }
}
