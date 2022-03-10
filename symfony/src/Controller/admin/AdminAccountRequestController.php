<?php

namespace App\Controller\admin;

use App\Entity\AccountRequest;
use App\Entity\User;
use App\Form\AccountRequest1Type;
use App\Repository\AccountRequestRepository;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/user/request')]
class AdminAccountRequestController extends AbstractController
{
    #[Route('/', name: 'app_admin_account_request_index', methods: ['GET'])]
    public function index(AccountRequestRepository $accountRequestRepository): Response
    {
        return $this->render('admin/account_request/index.html.twig', [
            'account_requests' => $accountRequestRepository->findBy(['isValid' => '0'],),
        ]);
    }

    #[Route('/{id}', name: 'app_admin_account_request_show', methods: ['GET'])]
    public function show(AccountRequest $accountRequest): Response
    {
        return $this->render('admin/account_request/show.html.twig', [
            'account_request' => $accountRequest,
        ]);
    }

    #[Route('/{id}/validate', name: 'app_admin_account_request_validate', methods: ['GET', 'POST'])]
    public function validate(Request $request, AccountRequest $accountRequest, AccountRequestRepository $accountRequestRepository, UserPasswordHasherInterface $userPasswordHasherInterface, UserRepository $userRepository, MailerInterface $mailer): Response
    {
        if ($this->isCsrfTokenValid('validate'.$accountRequest->getId(), $request->request->get('_token'))) {
            $accountRequest->setIsValid(true);
            $accountRequestRepository->add($accountRequest);

            $role = strtoupper($accountRequest->getType());
            $user = (new User())
                ->setEmail($accountRequest->getEmail())
                ->setFirstname($accountRequest->getFirstName())
                ->setLastname($accountRequest->getLastName())
                ->setPhone($accountRequest->getPhone())
                ->setCompany($accountRequest->getCompany())
                ->setRoles(["ROLE_{$role}"]);

            $password = random_bytes(10);
            $user->setPassword($userPasswordHasherInterface->hashPassword($user, $password));

            $userRepository->add($user);
        }

        return $this->redirectToRoute('app_admin_account_request_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'app_admin_account_request_delete', methods: ['POST'])]
    public function delete(Request $request, AccountRequest $accountRequest, AccountRequestRepository $accountRequestRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$accountRequest->getId(), $request->request->get('_token'))) {
            $accountRequestRepository->remove($accountRequest);
        }

        return $this->redirectToRoute('app_admin_account_request_index', [], Response::HTTP_SEE_OTHER);
    }
}
