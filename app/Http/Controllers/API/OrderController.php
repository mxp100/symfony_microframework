<?php


namespace App\Http\Controllers\API;


use App\Exceptions\ResponseException;
use App\Services\OrderService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Framework\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class OrderController extends BaseController
{
    protected $service;

    public function __construct()
    {
        $this->service = new OrderService();
    }

    /**
     * Create order
     *
     * @param Request $request
     * @return array
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function create(Request $request)
    {

        $orderId = $this->service->create($request->request->get('good_ids'));

        return [
            'order_id' => $orderId
        ];
    }

    /**
     * @param Request $request
     * @param int $orderId
     * @throws ResponseException
     */
    public function pay(Request $request, int $orderId)
    {
        try {
            $this->service->pay(
                $orderId,
                $request->request->get('sum')
            );
        } catch (Throwable $exception) {
            throw ResponseException::fromException($exception, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}