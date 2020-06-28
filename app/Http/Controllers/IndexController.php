<?php


namespace App\Http\Controllers;


class IndexController
{
    public function index()
    {
        dd(url('test'));
        return view('index', [
            'app_name' => env('APP_NAME'),
        ]);
    }
}