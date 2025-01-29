<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Ration;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    public function index(): ResourceCollection
    {
        $orders = Order::query()->latest()->paginate();
        return OrderResource::collection($orders);

    }

    public function show(Order $order): OrderResource
    {
        return OrderResource::make($order->load('tarrif', 'rations'));
    }

    public function store(StoreOrderRequest $request): JsonResponse
    {
        DB::transaction(function () use ($request) {

            $order = Order::query()->create($request->only([
                'client_name', 'client_phone', 'tarrif_id', 'schedule_type', 'comment',
            ]));
            $tariff = $order->tarrif;
            $rations = [];
            $scheduleType = $order->schedule_type;
            $rationCount = 1;
            $shouldCreateRation = false;


            foreach ($request->validated('date_ranges') as $dateRange) {
                $from = Carbon::parse($dateRange['from']);
                $to = Carbon::parse($dateRange['to']);

                while ($from <= $to) {

                    switch ($scheduleType) {
                        case 'EVERY_DAY':
                            $shouldCreateRation = true;
                            break;
                        case 'EVERY_OTHER_DAY':
                            $shouldCreateRation = $from->dayOfYear % 2 === 1;
                            break;
                        case 'EVERY_OTHER_DAY_TWICE':
                            $shouldCreateRation = $from->dayOfYear % 2 === 1 || $from->eq($to);
                            $rationCount = $shouldCreateRation && !$from->eq($to) ? 2 : 1;
                            break;
                    }

                    if ($shouldCreateRation) {
                        $deliveryDate = $from->copy();
                        $cookingDate = $tariff->cooking_day_before ? $deliveryDate->copy()->subDay() : $deliveryDate->copy();

                        for ($i = 0; $i < $rationCount; $i++) {
                            $rations[] = $this->createRation($order->id, $cookingDate, $deliveryDate);
                        }
                    }

                    $from->addDay();
                }

            }


            Ration::query()->insert($rations);
            $deliveryDates = collect($rations)->pluck('delivery_date');

            $order->update([
                'first_date' => $deliveryDates->min(),
                'last_date' => $deliveryDates->max(),
            ]);

        });

        return response()->json([
            'success' => true,
        ]);
    }


    private function createRation(int $orderId, Carbon $cookingDate, Carbon $deliveryDate): array
    {
        return [
            'order_id' => $orderId,
            'cooking_date' => $cookingDate->toDateTimeString(),
            'delivery_date' => $deliveryDate->toDateTimeString(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
