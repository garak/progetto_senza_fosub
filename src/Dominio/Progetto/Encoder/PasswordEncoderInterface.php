<?php

namespace Dominio\Progetto\Encoder;

interface PasswordEncoderInterface
{
    public function encode(string $password): string;
}
