<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function beforeCreate(): void
    {
        $this->record['type'] = 'simple';
        dd($this->record);
        if (strpos($this->record['link'], 'https://') === true && strpos($this->record['link'], 'http://') === true)
            $this->record['link'] = str_replace(['https://', 'http://'], '', $this->record['link']);
    }

}
