<?php


namespace App\Services;


use App\Entity\Good;

class GoodService
{
    public function getAll()
    {
        return em()->getRepository(Good::class)->findAll();
    }
}