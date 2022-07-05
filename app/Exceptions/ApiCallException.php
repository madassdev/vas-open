<?php

namespace App\Exceptions;

use Exception;

class ApiCallException extends Exception
{
    public function __construct($message, $code = 400, $data=null)
    {
        $this->message = $message;
        $this->code = $code;
        $this->data = $data;
    }

    public function render()
    {
        return response()->json(['error' =>
        [
            'message' => '[API CALL ERROR:] '.$this->message,

        ]], $this->code);
    }
}
