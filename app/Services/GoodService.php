<?php


namespace App\Services;


use App\Entity\Good;
use Doctrine\ORM\Tools\Pagination\Paginator;

class GoodService
{
    public function get($offset = 0, $limit = 100)
    {
        $builder = em()->getRepository(Good::class)
            ->createQueryBuilder('Goods')
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        $query = $builder->getQuery();

        $paginator = new Paginator($query);

        $total = $paginator->count();
        $goods = $paginator->getIterator()->getArrayCopy();

        return [
            'total' => $total,
            'goods' => $goods,
        ];

    }
}