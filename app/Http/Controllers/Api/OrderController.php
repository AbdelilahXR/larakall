<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\State;
use App\Http\Resources\OrderResource;

class OrderController extends Controller
{
    public function index(Request $request)
    {

        $orders = Order::query();

        if ($request->has('store')) {
            $orders = $orders->where('stores_id', $request->user()->stores->where('id', $request->store)->first()->id);
        }
        else {
            $orders = $orders->where('stores_id',  $request->user()->stores->first()->id);
        }

        $orders = $orders->filterByDateRange($request?->from, $request?->to);
    
        return response()->json(OrderResource::make($orders->get()->first()));

    }



    public function statistics(Request $request)
    {

        $statistics = [
            'shipped' => [
                'type' => 'delivery',
                'color' => null,
                'sum' => 0,
                'count' => 0
            ],
            'delivered' => [
                'type' => 'delivery',
                'color' => null,
                'sum' => 0,
                'count' => 0
            ],
            'canceled' => [
                'type' => 'confirmation',
                'color' => null,
                'sum' => 0,
                'count' => 0
            ],
            'new' => [
                'type' => 'confirmation',
                'color' => null,
                'sum' => 0,
                'count' => 0
            ]
        ];

        $orders = Order::query();

        if ($request->has('store')) {
            $orders = $orders->where('stores_id', $request->user()->stores->where('id', $request->store)->first()->id);
        }
        else {
            $orders = $orders->where('stores_id',  $request->user()->stores->first()->id);
        }

        if ($request->has('status')) {
            $orders = $orders->where('status', $request->status);
        }

        $orders = $orders->filterByDateRange($request?->from, $request?->to);

        foreach ($statistics as $key => $statistic) {
            $state = State::where('name', $key)->where('type', $statistic['type'])->first();

            if (!$state)
            {
                continue;
            }

            if ($statistic['type'] == 'delivery') {
                $orders = $orders->withLastDeliveryState($state->name);
            } else {
                $orders = $orders->withLastConfirmationState($state->name);
            }

            $statistics[$key]['count'] = $orders->count();
            $statistics[$key]['sum'] = $orders->sum('price');
            $statistics[$key]['color'] = $state->color;
        }

        return response()->json($statistics);


    }


}
