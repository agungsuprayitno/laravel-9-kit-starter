<?php


namespace App\Orders\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class OrderNotFoundException extends Exception
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
                "code" => "order-not-found",
                "attribute" => "order",
                "message" => "Order Not Found."
            ]
        ], 404);
    }
}
