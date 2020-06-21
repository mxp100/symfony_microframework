<?php


namespace App\Services;


use App\Entity\Good;
use App\Entity\Order;
use Doctrine\DBAL\LockMode;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Exception;
use Throwable;

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

    /**
     * Pay order
     *
     * @param int $orderId
     * @param float $sum
     * @throws Throwable
     */
    public function pay(int $orderId, float $sum): void
    {
        em()->transactional(function (EntityManager $em) use ($orderId, $sum) {
            /** @var Order $order */
            if (!$order = $em->getRepository(Order::class)->find($orderId, LockMode::PESSIMISTIC_WRITE)) {
                throw new Exception('order not found');
            }

            if ($order->getStatus() !== Order::STATUS_NEW) {
                throw new Exception('status not new');
            }

            $total = 0;
            foreach ($order->getGoods()->getIterator() as $good) {
                /** @var Good $good */
                $total += $good->getPrice();
            }
            if ((int)round($total * 1000) !== (int)round($sum * 1000)) {
                throw new Exception('incorrect sum');
            }

            $paymentService = new PaymentService();
            if ($paymentService->checkPayment()) {
                $order->setStatus(Order::STATUS_PAYED);
                $em->persist($order);
                return;
            }

            throw new Exception('payment not processed');
        });
    }
}