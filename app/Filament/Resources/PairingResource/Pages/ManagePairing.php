<?php

namespace App\Filament\Resources\PairingResource\Pages;

use App\Filament\Resources\PairingResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePairing extends ManageRecords
{
    protected static string $resource = PairingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //Actions\CreateAction::make(),
        ];
    }
}
