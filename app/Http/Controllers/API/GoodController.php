<?php


namespace App\Http\Controllers\API;


use App\Services\GoodService;
use Framework\Request;

class GoodController extends BaseController
{
    public function index(Request $request)
    {
        $service = new GoodService;

        return $service->get(
            $request->query->get('offset', 0),
            $request->query->get('limit', 100)
        );
    }
}