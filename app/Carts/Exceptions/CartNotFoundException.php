<?php


namespace App\Carts\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class CartNotFoundException extends Exception
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
                "code" => "cart-not-found",
                "attribute" => "cart",
                "message" => "Cart Not Found."
            ]
        ], 404);
    }
}
