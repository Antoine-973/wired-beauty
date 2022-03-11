<?php

namespace App\Controller\admin;

use App\Repository\AccountRequestRepository;
use App\Repository\EstimationRequestRepository;
use App\Repository\ReportRepository;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/{_locale<%app.supported_locales%>}/admin')]
#[IsGranted('ROLE_ADMIN')]
class AdminDashboardController extends AbstractController
{
    #[Route('/', name: 'app_admin_dashboard')]
    public function index(UserRepository $userRepository, AccountRequestRepository $accountRequestRepository, EstimationRequestRepository $estimationRequestRepository, ReportRepository $reportRepository): Response
    {
        return $this->render('admin/dashboard/index.html.twig', [
            'users' => $userRepository->findAll(),
            'account_requests' => $accountRequestRepository->findBy(['isValid' => '0']),
            'estimation_requests' => $estimationRequestRepository->findAll(),
            'reports' => $reportRepository->findAll(),
        ]);
    }
}
