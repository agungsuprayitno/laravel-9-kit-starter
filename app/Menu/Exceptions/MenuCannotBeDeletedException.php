<?php


namespace App\Menu\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class MenuCannotBeDeletedException extends Exception
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
                "code" => "menu-cannot-be-deleted",
                "attribute" => "menu",
                "message" => "Menu cannot be deleted."
            ]
        ], 404);
    }
}
