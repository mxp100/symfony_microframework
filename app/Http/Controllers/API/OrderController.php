<?php


namespace App\Http\Controllers\API;


use App\Services\OrderService;
use Framework\Request;

class OrderController extends BaseController
{
    public function create(Request $request)
    {
        $service = new OrderService();
        $orderId = $service->create($request->request->get('good_ids'));

        return [
            'order_id' => $orderId
        ];
    }
}