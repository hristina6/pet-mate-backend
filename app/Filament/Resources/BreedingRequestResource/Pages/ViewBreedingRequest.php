<?php

namespace App\Filament\Resources\BreedingRequestResource\Pages;

use App\Filament\Resources\BreedingRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewBreedingRequest extends ViewRecord
{
    protected static string $resource = BreedingRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
