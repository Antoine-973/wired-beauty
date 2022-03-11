<?php

namespace App\Controller;

use App\Entity\BuyReportRequest;
use App\Entity\Report;
use App\Entity\User;
use App\Form\Report2Type;
use App\Repository\BuyReportRequestRepository;
use App\Repository\ReportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/{_locale<%app.supported_locales%>}/report')]
class BuyReportController extends AbstractController
{
    #[Route('/', name: 'app_buy_report_index', methods: ['GET'])]
    public function index(ReportRepository $reportRepository): Response
    {
        return $this->render('buy_report/index.html.twig', [
            'reports' => $reportRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_buy_report_show', methods: ['GET', 'POST'])]
    public function show(Report $report, BuyReportRequestRepository $buyReportRequestRepository): Response
    {
        $alreadyAsked = $buyReportRequestRepository->findOneBy([
            'report' => $report,
            'requester' => $this->getUser()
        ]);
        $alreadyAsked = $alreadyAsked !== null;
        return $this->render('buy_report/show.html.twig', [
            'report' => $report,
            'already_asked' => $alreadyAsked
        ]);
    }

    #[Route('/request/{id}', name: 'app_buy_report_request', methods: ['GET', 'POST'])]
    public function requestReport(Report $report, BuyReportRequestRepository $buyReportRequestRepository, EntityManagerInterface $entityManager): Response
    {
        $alreadyAsked = $buyReportRequestRepository->findOneBy([
            'report' => $report,
            'requester' => $this->getUser()
        ]);

        if($alreadyAsked === null){
            //dd(null);
            $buyReporter = (new BuyReportRequest())
                ->setReport($report)
                ->setRequester($this->getUser())
                ->setAccepted(false);

            $entityManager->persist($buyReporter);
            $entityManager->flush();
        }
        //dd('not null');
        return $this->redirectToRoute('app_buy_report_index' );
    }

}
