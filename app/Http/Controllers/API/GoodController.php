<?php


namespace App\Http\Controllers\API;


use App\Services\GoodService;

class GoodController extends BaseController
{
    public function index()
    {
        $service = new GoodService;

        return $service->getAll();
    }
}