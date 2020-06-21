<?php


namespace App\Services;


use App\Entity\Good;
use App\Entity\Order;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class OrderService
{
    /**
     * Create order and return id
     *
     * @param integer[] $goodIds
     * @return int
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function create(array $goodIds)
    {
        /** @var Good[] $goods */
        $goods = em()->getRepository(Good::class)->findBy(['id' => $goodIds]);
        $order = new Order();
        $order->setStatus(Order::STATUS_NEW);
        em()->persist($order);

        foreach ($goods as $good) {
            $order->getGoods()->add($good);
        }
        em()->flush();

        return $order->getId();
    }
}