<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class InvalidTokenException extends Exception
{
    /**
     * Create a new exception instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct("Token sudah tidak valid!");
    }

    /**
     * Report or log the exception.
     *
     * @return void
     */
    public function report()
    {
        
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return response()->json([
            'status' => 'error',
            'message' => $this->getMessage(),
        ], Response::HTTP_UNAUTHORIZED);
    }
}
