<?php


namespace App\Order\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class OrderCannotBeDeletedException extends Exception
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
                "code" => "order-cannot-be-deleted",
                "attribute" => "order",
                "message" => "Order cannot be deleted."
            ]
        ], 404);
    }
}
