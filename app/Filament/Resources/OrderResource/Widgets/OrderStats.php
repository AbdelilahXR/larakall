<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Filament\Resources\OrderResource\Pages\ListOrders;
use App\Models\Order;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class OrderStats extends BaseWidget
{
    use InteractsWithPageTable;

    protected static ?string $pollingInterval = null;

    protected function getTablePage(): string
    {
        return ListOrders::class;
    }

    protected function getStats(): array
    {
        $orderData = Trend::query(Order::query()->filterByUser())
            ->between(
                start: now()->subYear(),
                end: now(),
            )
            ->perMonth()
            ->count();

        return [
            Stat::make(__('all.orders'), $this->getPageTableQuery()->filterByUser()->count())
                ->chart(
                    $orderData
                        ->map(fn(TrendValue $value) => $value->aggregate)
                        ->toArray()
                )
            ,
            Stat::make(__('all.new_orders'), $this->getPageTableQuery()
                // ->color('success')
                    ->withLastConfirmationState('New')
                    ->filterByUser()
                    ->count(),
                ),
            Stat::make(__('all.average_price'), number_format($this->getPageTableQuery()->filterByUser()->avg('price'), 2)),
        ];
    }
}
