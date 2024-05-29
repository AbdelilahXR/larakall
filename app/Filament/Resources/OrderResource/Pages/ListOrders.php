<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Models\Order;
use App\Models\State;
use Filament\Actions;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListOrders extends ListRecords
{

    use ExposesTableToWidgets;

    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        $tabs = [
            null => Tab::make('All')->badge(Order::query()->filterByUser()->count()),
        ];

        $statesToInclude = State::where('show_stat', 1)->get();

        foreach ($statesToInclude as $state) {
            $tabs[$state->name] = Tab::make()->query(function ($query) use ($state) {
                ($state->type == 'confirmation') ?
                $query->withLastConfirmationState($state->name)
                :
                $query->withLastDeliveryState($state->name);

                //return dd($query->toSql());
            })
                ->badge(($state->type == 'confirmation') ?
                    Order::query()->withLastConfirmationState($state->name)->filterByUser()->count()
                    :
                    Order::query()->withLastDeliveryState($state->name)->filterByUser()->count());
        }

        return $tabs;
    }

    protected function getHeaderWidgets() : array
    {
        return OrderResource::getWidgets();
    }
}
