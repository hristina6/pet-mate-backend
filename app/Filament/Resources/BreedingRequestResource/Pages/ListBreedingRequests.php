<?php

namespace App\Filament\Resources\BreedingRequestResource\Pages;

use App\Filament\Resources\BreedingRequestResource;
use Filament\Resources\Pages\ListRecords;

class ListBreedingRequests extends ListRecords
{
    protected static string $resource = BreedingRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
