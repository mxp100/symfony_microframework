<?php


namespace Framework\Contracts;


use Doctrine\ORM\EntityManager;

interface DatabaseContract
{
    /**
     * Return doctrine entity manager;
     * @return EntityManager
     */
    public function getEntityManager(): EntityManager;
}