<?php


namespace App\Customers\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class CustomerNotFoundException extends Exception
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
                "code" => "customer-not-found",
                "attribute" => "customer",
                "message" => "Customer Not Found."
            ]
        ], 404);
    }
}
