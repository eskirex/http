<?php

namespace Eskirex\Component\HTTP\Exceptions;

use Throwable;

class RuntimeException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}