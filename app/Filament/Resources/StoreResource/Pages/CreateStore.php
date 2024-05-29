<?php

namespace App\Filament\Resources\StoreResource\Pages;

use App\Filament\Resources\StoreResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateStore extends CreateRecord
{
    protected static string $resource = StoreResource::class;

    protected function beforeCreate(): void
    {

        if (strpos($this->record['link'], 'https://') === true && strpos($this->record['link'], 'http://') === true)
            $this->record['link'] = str_replace(['https://', 'http://'], '', $this->record['link']);
    }

}
