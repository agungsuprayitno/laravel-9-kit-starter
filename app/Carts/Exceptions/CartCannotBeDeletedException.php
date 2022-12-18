<?php


namespace App\Carts\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class CartCannotBeDeletedException extends Exception
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
                "code" => "cart-cannot-be-deleted",
                "attribute" => "cart",
                "message" => "Cart cannot be deleted."
            ]
        ], 404);
    }
}
