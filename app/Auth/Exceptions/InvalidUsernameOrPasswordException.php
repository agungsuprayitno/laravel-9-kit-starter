<?php


namespace App\Auth\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class InvalidUsernameOrPasswordException extends Exception
{
    /**
     * Report the exception.
     *
     * @return bool|null
     */
    public function report()
    {
        return false;
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function render($request): JsonResponse
    {
        return response()->json([ "error" =>
            [
                "code" => "invalid-username-password",
                "attribute" => "username-password",
                "message" => "Invalid username or password"
            ]
        ], 404);
    }
}
