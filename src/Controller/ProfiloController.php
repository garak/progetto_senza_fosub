<?php

namespace App\Controller;

use App\Form\CambioPasswordType;
use Dominio\Progetto\Command\Utente as Command;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use SimpleBus\Message\Bus\MessageBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class ProfiloController extends AbstractController
{
    /**
     * @Route("/cambia-password", name="cambia_password")
     * @Method({"GET", "PUT"})
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
