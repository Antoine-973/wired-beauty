<?php

namespace App\Controller;

use App\Repository\ReportRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_CLIENT')]
#[Route('/{_locale<%app.supported_locales%>}/order')]
class OrderController extends AbstractController
{

    #[Route('/', name: 'app_order')]
    public function index(ReportRepository $reportRepository): Response
    {
        $user = $this->getUser();
        $results = array_filter( $user->getBuyReportRequests()->toArray(), fn($buyReport) => $buyReport->getAccepted() );
        $results = array_map( fn($buyReport) => $buyReport->getReport(), $results);

        return $this->render('order/index.html.twig', [
            'reports' => $results
        ]);
    }
}
