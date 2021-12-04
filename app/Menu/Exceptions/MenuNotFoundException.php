<?php


namespace App\Menu\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class MenuNotFoundException extends Exception
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
                "code" => "menu-not-found",
                "attribute" => "menu",
                "message" => "Menu Not Found."
            ]
        ], 404);
    }
}
