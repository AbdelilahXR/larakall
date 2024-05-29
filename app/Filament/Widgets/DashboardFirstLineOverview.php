<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class DashboardFirstLineOverview extends BaseWidget
{
    use InteractsWithPageFilters;

    protected function getStats(): array
    {

        $filterStore = $this->filters['store'] ?? null;

        $from = $this->filters['startDate'] ?? null;
        $to = $this->filters['endDate'] ?? null;

        $orderData = Trend::query(Order::query()->filterByStore($filterStore)->filterByDateRange($from, $to)->filterByUser())
            ->between(
                start: now()->subYear(),
                end: now(),
            )
            ->perMonth()
            ->count();

        $ordersDiff = Order::query()
            ->filterByStore($filterStore)
            ->filterByDateRange($from, $to)
            ->filterByUser()
            ->selectRaw('SUM(CASE WHEN created_at BETWEEN ? AND ? THEN 1 ELSE 0 END) AS last_month_orders,
                         SUM(CASE WHEN created_at BETWEEN ? AND ? THEN 1 ELSE 0 END) AS this_month_orders',
                [now()->subMonth()->startOfMonth()->subMonth(), now()->subMonth()->endOfMonth()->subMonth(),
                    now()->startOfMonth(), now()->endOfMonth()])
            ->first();

        $lastMonthOrders = $ordersDiff->last_month_orders;
        $thisMonthOrders = $ordersDiff->this_month_orders;
        $dffThisLastMonth = $this->countPercentage($thisMonthOrders, $lastMonthOrders);
        $dffThisLastMonthDesc = $dffThisLastMonth > 0 ? '+%' . $dffThisLastMonth . ' ' . __("all.increase_this_month") : '-%' . $dffThisLastMonth * -1 . ' ' . __("all.decrease_this_month");

        $newOrders = Trend::query(Order::query()->filterByStore($filterStore)->filterByDateRange($from, $to)->filterByUser())
            ->between(
                start: now()->subMonth(),
                end: now(),
            )
            ->perDay()
            ->count();

        $newOrdersDiff = Order::query()
            ->filterByStore($filterStore)
            ->filterByDateRange($from, $to)
            ->filterByUser()
            ->withLastConfirmationState('New')
            ->selectRaw('SUM(CASE WHEN created_at BETWEEN ? AND ? THEN 1 ELSE 0 END) AS yesterday_orders,
                         SUM(CASE WHEN created_at BETWEEN ? AND ? THEN 1 ELSE 0 END) AS today_orders',
                [now()->subDay()->startOfDay(), now()->subDay()->endOfDay(),
                    now()->startOfDay(), now()->endOfDay()])
            ->first();

        $lastDayNewOrders = $newOrdersDiff->yesterday_orders;
        $todayNewOrders = $newOrdersDiff->today_orders;
        $dffThisLastDay = $this->countPercentage($todayNewOrders, $lastDayNewOrders);

        $dffThisLastDayDesc = $dffThisLastDay > 0 ? '+%' . $dffThisLastDay . ' ' . __("all.increase_this_day") : '-%' . $dffThisLastDay * -1 . ' ' . __("all.decrease_this_day");

        $confirmedOrders = Trend::query(Order::query()->filterByStore($filterStore)->filterByDateRange($from, $to)->filterByUser()->withLastConfirmationState('Confirmed'))
            ->between(
                start: now()->subMonth(),
                end: now(),
            )
            ->perDay()
            ->count();

        $confirmedOrdersDiff = Order::query()
            ->filterByStore($filterStore)
            ->filterByDateRange($from, $to)
            ->filterByUser()
            ->withLastConfirmationState('Confirmed')
            ->selectRaw('SUM(CASE WHEN created_at BETWEEN ? AND ? THEN 1 ELSE 0 END) AS yesterday_orders,
                         SUM(CASE WHEN created_at BETWEEN ? AND ? THEN 1 ELSE 0 END) AS today_orders',
                [now()->subDay()->startOfDay(), now()->subDay()->endOfDay(),
                    now()->startOfDay(), now()->endOfDay()])
            ->first();

        $lastDayconfirmedOrders = $confirmedOrdersDiff->yesterday_orders;
        $todayConfirmedOrders = $confirmedOrdersDiff->today_orders;
        $dffConfirmedThisLastDay = $this->countPercentage($todayConfirmedOrders, $lastDayconfirmedOrders);

        $dffConfirmedThisLastDayDesc = $dffConfirmedThisLastDay > 0 ? '+%' . $dffConfirmedThisLastDay . ' ' . __("all.increase_this_day") : '-%' . $dffConfirmedThisLastDay * -1 . ' ' . __("all.decrease_this_day");

        return [
            Stat::make(__('all.orders'), Order::query()->filterByStore($filterStore)->filterByDateRange($from, $to)->filterByUser()->count())
                ->color('primary')
                ->description($dffThisLastMonthDesc)
                ->descriptionIcon($dffThisLastMonth > 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->chart(
                    $orderData
                        ->map(fn(TrendValue $value) => $value->aggregate)
                        ->toArray()
                )
                ->icon('heroicon-o-shopping-cart'),
            Stat::make(__('all.new_orders'), Order::query()
                    ->filterByStore($filterStore)
                    ->filterByDateRange($from, $to)
                    ->withLastConfirmationState('New')
                    ->filterByUser()
                    ->count())
                ->icon('heroicon-o-squares-plus')
                ->description($dffThisLastDayDesc)
                ->descriptionIcon($dffThisLastDay > 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color('info')
                ->chart(
                    $newOrders
                        ->map(fn(TrendValue $value) => $value->aggregate)
                        ->toArray()
                ),
            Stat::make(__('all.confirmed_orders'), Order::query()
                    ->filterByDateRange($from, $to)
                    ->filterByStore($filterStore)
                    ->withLastConfirmationState('Confirmed')
                    ->filterByUser()
                    ->count())
                ->icon('heroicon-o-check-badge')
                ->description($dffConfirmedThisLastDayDesc)
                ->descriptionIcon($dffConfirmedThisLastDay > 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color('success')
                ->chart(
                    $confirmedOrders
                        ->map(fn(TrendValue $value) => $value->aggregate)
                        ->toArray()
                ),
        ];
    }

    public static function countPercentage($thisTime, $lastTime)
    {

        if ($thisTime == 0 && $lastTime == 0) {
            return 0;
        }

        if ($thisTime == 0) {
            return -100;
        }

        if ($lastTime == 0) {
            return 100;
        }

        return $lastTime != 0 ? number_format(($thisTime - $lastTime) / $lastTime * 100, 2) : 100;
    }
}
