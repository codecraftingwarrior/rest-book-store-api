<?php

namespace App\Controller\Traits;

use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Validator\ConstraintViolationList;

trait Validations
{
    public function validate(ConstraintViolationList $violations)
    {
        if (count($violations)) {
            $message = 'Impossible de procéder à cette opération. ';
            foreach ($violations as $violation) {
                $message .= sprintf("%s: %s ", $violation->getPropertyPath(), $violation->getMessage());
            }
            throw new UnprocessableEntityHttpException($message);
        }
    }
}
