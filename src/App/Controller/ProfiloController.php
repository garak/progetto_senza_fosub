<?php

namespace App\Controller;

use App\Form\CambioPasswordType;
use Dominio\Progetto\Command\Utente as Command;
use SimpleBus\Message\Bus\MessageBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ProfiloController extends AbstractController
{
    /**
     * @Route("/cambia-password", name="cambia_password", methods={"GET", "PUT"})
     */
    public function cambiaPassword(MessageBus $bus, Request $request): Response
    {
        $command = new Command\CambiaPasswordCommand($this->getUser());
        $form = $this->createForm(CambioPasswordType::class, $command, ['method' => 'PUT']);
        if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {
            $bus->handle($command);

            return $this->redirectToRoute('homepage');
        }

        return $this->render('profilo/cambia_password.html.twig', ['form' => $form->createView()]);
    }
}
