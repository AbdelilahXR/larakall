<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Resources\Pages\ManageRecords;
use Filament\Actions;


class ManageProducts extends ManageRecords
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
           
            Actions\CreateAction::make()
            ->mutateFormDataUsing(function (array $data): array {
                $data['type'] = 'simple';
                return $data;
            })
                
        ];
    }
}
