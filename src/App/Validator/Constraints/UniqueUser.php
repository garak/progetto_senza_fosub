<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UniqueUser extends Constraint
{
    public string $message = 'Email "%email%" già registrata.';

    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }
}
