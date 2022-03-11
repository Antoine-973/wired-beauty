<?php

namespace App\Controller\admin;

use App\Entity\AccountRequest;
use App\Entity\User;
use App\Form\AccountRequest1Type;
use App\Repository\AccountRequestRepository;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\ResetPassword\Controller\ResetPasswordControllerTrait;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

#[Route('/{_locale<%app.supported_locales%>}/admin/user/request')]
#[IsGranted('ROLE_ADMIN')]
class AdminAccountRequestController extends AbstractController
{
    use ResetPasswordControllerTrait;

    private $resetPasswordHelper;

    public function __construct(ResetPasswordHelperInterface $resetPasswordHelper)
    {
        $this->resetPasswordHelper = $resetPasswordHelper;
    }

    #[Route('/', name: 'app_admin_account_request_index', methods: ['GET'])]
    public function index(AccountRequestRepository $accountRequestRepository): Response
    {
        return $this->render('admin/account_request/index.html.twig', [
            'account_requests' => $accountRequestRepository->findBy(['isValid' => '0']),
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
    public function validate(Request $request, AccountRequest $accountRequest, AccountRequestRepository $accountRequestRepository, UserPasswordHasherInterface $userPasswordHasherInterface, UserRepository $userRepository, MailerInterface $mailer, TranslatorInterface $translator): Response
    {
        if ($this->isCsrfTokenValid('validate' . $accountRequest->getId(), $request->request->get('_token'))) {
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

            try {
                $resetToken = $this->resetPasswordHelper->generateResetToken($user);
            } catch (ResetPasswordExceptionInterface $e) {
                // If you want to tell the user why a reset email was not sent, uncomment
                // the lines below and change the redirect to 'app_forgot_password_request'.
                // Caution: This may reveal if a user is registered or not.
                //
                $this->addFlash('reset_password_error', sprintf(
                    '%s - %s',
                    $translator->trans(ResetPasswordExceptionInterface::MESSAGE_PROBLEM_HANDLE, [], 'ResetPasswordBundle'),
                    $translator->trans($e->getReason(), [], 'ResetPasswordBundle')
                ));

                return $this->redirectToRoute('app_admin_account_request_validate');
            }

            $email = (new TemplatedEmail())
                ->from(new Address('wired-beauty@gmail.com', 'Wired Beauty'))
                ->to($user->getEmail())
                ->subject('Wired-Beauty - Your account request has been validated')
                ->htmlTemplate('reset_password/email_validate_account_request.html.twig')
                ->context([
                    'resetToken' => $resetToken,
                ]);

            $mailer->send($email);
        }

        return $this->redirectToRoute('app_admin_account_request_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'app_admin_account_request_delete', methods: ['POST'])]
    public function delete(Request $request, AccountRequest $accountRequest, AccountRequestRepository $accountRequestRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $accountRequest->getId(), $request->request->get('_token'))) {
            $accountRequestRepository->remove($accountRequest);
        }

        return $this->redirectToRoute('app_admin_account_request_index', [], Response::HTTP_SEE_OTHER);
    }
}
