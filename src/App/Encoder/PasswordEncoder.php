<?php

namespace App\Encoder;

use Dominio\Progetto\Encoder\PasswordEncoderInterface;
use Dominio\Progetto\Model\Entity\Utente;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class PasswordEncoder implements PasswordEncoderInterface
{
    private EncoderFactoryInterface$encoderFactory;

    public function __construct(EncoderFactoryInterface $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }

    public function encode(string $password): string
    {
        $encoder = $this->encoderFactory->getEncoder(Utente::class);

        return $encoder->encodePassword($password, null);
    }
}
