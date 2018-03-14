<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;

final class AuthController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     * @Method("GET")
     */
    public function login(LoggerInterface $logger, Request $request): Response
    {
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('homepage');
        }

        return $this->render('auth/login.html.twig', [
            'last_username' => $request->getSession()->get(Security::LAST_USERNAME),
            'error' => $this->getLoginError($logger, $request),
        ]);
    }

    private function getLoginError(LoggerInterface $logger, Request $request): ?\Exception
    {
        $error = $request->getSession()->get(Security::AUTHENTICATION_ERROR);
        $request->getSession()->remove(Security::AUTHENTICATION_ERROR);
        // see https://github.com/symfony/symfony/issues/837#issuecomment-3000155
        if ($error instanceof \Exception && !$error instanceof AuthenticationException) {
            $logger->log('error', $error->getMessage());
            $error = new \Exception('Errore inatteso.');
        }

        return $error;
    }
}
