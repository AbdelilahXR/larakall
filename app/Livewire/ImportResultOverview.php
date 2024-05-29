<?php

namespace App\Livewire;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ImportResultOverview extends BaseWidget
{
    public $data;

    public function mount($data)
    {
        $this->data = $data;
    }


    protected function getStats(): array
    {
        return [
            Stat::make('Total', $this->data['total'])->label(__('all.total')),
            Stat::make('Inserted', $this->data['inserted'])->label(__('all.inserted')),
            Stat::make('Updated', $this->data['updated'])->label(__('all.updated')),
            Stat::make('Failed', $this->data['failed'])->label(__('all.failed')),
        ];
    }
}
