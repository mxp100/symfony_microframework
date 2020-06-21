<?php


namespace App\Http\Controllers\API;


use App\Entity\Good;
use Symfony\Component\HttpFoundation\Response;

class GoodController
{
    public function index(){
        $goods = em()->getRepository(Good::class)->findAll();

        return $goods;
    }
}