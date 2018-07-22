<?php

namespace Polidog\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

class ClientMimeType extends Constraint
{
    public $mimeTypes = [];
    public $mimeTypesMessage = 'The mime type of the file is invalid ({{ type }}). Allowed mime types are {{ types }}.';
}