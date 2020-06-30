<?php


namespace App\Http\Controllers\API;


use App\Exceptions\ResponseException;
use App\Services\OrderService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Framework\Request\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class OrderController extends BaseController
{
    /**
     * Create order
     *
     * @param OrderService $orderService
     * @param Request $request
     * @return array
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function create(OrderService $orderService, Request $request)
    {

        $orderId = $orderService->create($request->request->get('good_ids'));

        return [
            'order_id' => $orderId
        ];
    }

    /**
     * @param OrderService $orderService
     * @param Request $request
     * @param int $orderId
     * @throws ResponseException
     */
    public function pay(OrderService $orderService, Request $request, int $orderId)
    {
        try {
            $orderService->pay(
                $orderId,
                $request->request->get('sum')
            );
        } catch (Throwable $exception) {
            throw ResponseException::fromException($exception, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}