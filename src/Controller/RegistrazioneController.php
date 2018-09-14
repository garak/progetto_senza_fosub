<?php

namespace App\Controller;

use App\Form\RegistrazioneType;
use Dominio\Progetto\Command;
use SimpleBus\Message\Bus\MessageBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * @Route("/registrazione")
 */
final class RegistrazioneController extends AbstractController
{
    /**
     * @Route("", name="registrazione", methods={"GET", "POST"})
     */
    public function registrazione(MessageBus $bus, Request $request): Response
    {
        if ($this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('homepage');
        }
        $command = new Command\Utente\RegistraCommand();
        $form = $this->createForm(RegistrazioneType::class, $command);
        if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
            $bus->handle($command);

            return $this->redirectToRoute('registrazione_ok');
        }

        return $this->render('registrazione/registrazione.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/ok", name="registrazione_ok", methods="GET")
     */
    public function ok(): Response
    {
        if ($this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('homepage');
        }

        return $this->render('registrazione/ok.html.twig');
    }

    /**
     * @Route("/conferma/{token}", name="registrazione_conferma", methods="GET")
     */
    public function conferma(string $token, MessageBus $bus, Request $request): Response
    {
        if ($this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('homepage');
        }
        $command = new Command\Utente\ConfermaRegistrazioneCommand($token);
        $bus->handle($command);
        $token = new UsernamePasswordToken($command->utente, null, 'main');
        $session = $request->getSession();
        $session->set('_security_main', \serialize($token));

        return $this->redirectToRoute('homepage');
    }
}
