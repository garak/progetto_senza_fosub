<?php

namespace App\Validator\Constraints;

use App\Repository\UtenteRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Validator for UniqueUser constraint.
 */
final class UniqueUserValidator extends ConstraintValidator
{
    private UtenteRepository $utenteRepository;

    public function __construct(UtenteRepository $userRepository)
    {
        $this->utenteRepository = $userRepository;
    }

    /**
     * @param \Dominio\Progetto\Command\Utente\RegistraCommand $command
     * @param UniqueUser                                       $constraint
     */
    public function validate($command, Constraint $constraint): void
    {
        //  TODO qui probabilmente va adattato per supportare l'aggiornamento...
        if (!empty($command->email) && null !== $user = $this->utenteRepository->findByEmail($command->email)) {
            $this->context
                ->buildViolation($constraint->message, ['%email%' => $command->email])
                ->atPath('email')
                ->addViolation()
            ;
        }
    }
}
