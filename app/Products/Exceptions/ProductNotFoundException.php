<?php


namespace App\Products\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class ProductNotFoundException extends Exception
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
                "code" => "product-not-found",
                "attribute" => "product",
                "message" => "Product Not Found."
            ]
        ], 404);
    }
}
