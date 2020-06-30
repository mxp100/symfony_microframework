<?php


namespace Framework\Database;


use Doctrine\ORM\EntityManager;
use Symfony\Component\Serializer\Serializer;

interface DatabaseContract
{
    /**
     * Return doctrine entity manager;
     * @return EntityManager
     */
    public function getEntityManager(): EntityManager;

    /**
     * Return entity serializer;
     * @return Serializer
     */
    public function getSerializer(): Serializer;
}