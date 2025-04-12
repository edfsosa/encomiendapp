<?php

namespace App\Filament\Resources\TransportFormResource\Pages;

use App\Filament\Resources\TransportFormResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTransportForm extends EditRecord
{
    protected static string $resource = TransportFormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
