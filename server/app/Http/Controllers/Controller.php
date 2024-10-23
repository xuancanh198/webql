<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public function returnResponseData($status = 'success', $result, $type = "normal")
    {
        return response()->json([
            'status' => $status,
            'type' => $type,
            'result' => $result,
        ]);
    }

}
