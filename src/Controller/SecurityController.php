<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Brevo\Client\Configuration;
use Brevo\Client\Api\TransactionalEmailsApi;
use Brevo\Client\Model\SendSmtpEmail;
use Brevo\Client\Model\SendSmtpEmailSender;
use Brevo\Client\Model\SendSmtpEmailTo;
use Exception;
use Psr\Log\LogLevel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Log\Logger;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\LoginLink\LoginLinkHandlerInterface;
use GuzzleHttp\Client;
use Symfony\Contracts\Translation\TranslatorInterface;

class SecurityController extends AbstractController
{
    /**
     * @throws Exception
     */
    #[Route('/login', name: 'login')]
    public function requestLoginLink(LoginLinkHandlerInterface $loginLinkHandler, UserRepository $userRepository, Request $request, TranslatorInterface $translator): Response
    {
        if ($request->isMethod('POST')) {
            $email = $request->getPayload()->get('email');
            $user = $userRepository->findOneBy(['email' => $email]);
            if ($user === null) {
                return $this->render('security/request_login_link.html.twig', ['error' => $translator->trans('login.form.error')]);
            }

            $loginLinkDetails = $loginLinkHandler->createLoginLink($user);

            $config = (new Configuration)::getDefaultConfiguration()->setApiKey('api-key', $this->getParameter('brevo_api_key'));

            $apiInstance = new TransactionalEmailsApi(
                new Client(),
                $config
            );

            $email = (new SendSmtpEmail())
                ->setSubject("Connexion à l'admin")
                ->setTo([new SendSmtpEmailTo(["email" => $email])])
                ->setSender(new SendSmtpEmailSender(["email" => "no-reply@richardcrete.fr", "name" => "Richard Crété"]))
                ->setHtmlContent("<a href='{$loginLinkDetails->getUrl()}'>Connexion</a>");

            try {
                $result = $apiInstance->sendTransacEmail($email);
            } catch (Exception $e) {
                (new Logger())->log(LogLevel::ERROR, $e->getMessage());
                throw new Exception($e->getMessage());
            }

            return $this->render('security/login_link_sent.html.twig');
        }

        return $this->render('security/request_login_link.html.twig');
    }
}