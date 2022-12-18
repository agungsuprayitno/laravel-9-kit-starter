<?php


namespace App\Customers\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class CustomerCannotBeDeletedException extends Exception
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
                "code" => "customer-cannot-be-deleted",
                "attribute" => "product",
                "message" => "Customer cannot be deleted."
            ]
        ], 404);
    }
}
