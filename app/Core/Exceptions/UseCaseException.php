<?php

namespace Core\Exceptions;

use Core\Exceptions\CoreException;

class UseCaseException extends CoreException {
    public function mensagemAmigavel(): string
    {
        return $this->message;
    }

    public function mensagemLog(): string
    {
        return $this->message;
    }
}


