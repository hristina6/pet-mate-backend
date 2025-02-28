<?php

namespace App\Filament\Resources\BreedingRequestResource\Pages;

use App\Filament\Resources\BreedingRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBreedingRequest extends EditRecord
{
    protected static string $resource = BreedingRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
