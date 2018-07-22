<?php

namespace Polidog\Validator\Constraints;


use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ClientMimeTypeValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if ($value instanceof UploadedFile && $value->isValid()) {
            $mimeTypes = (array) $constraint->mimeTypes;

            $mime = $value->getClientMimeType();
            foreach ($mimeTypes as $mimeType) {
                if ($mimeType === $mime) {
                    return;
                }
            }

            $this->context->buildViolation($constraint->mimeTypesMessage)
                ->setParameter('{{ type }}', $mime)
                ->setParameter('{{ types }}', implode(', ', $mimeTypes))
                ->addViolation();
        }
    }

}