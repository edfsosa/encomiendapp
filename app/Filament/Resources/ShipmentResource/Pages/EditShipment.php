<?php

namespace App\Filament\Resources\ShipmentResource\Pages;

use App\Filament\Resources\ShipmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;


class EditShipment extends EditRecord
{
    protected static string $resource = ShipmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make('Imprimir Ticket')
                ->label('Imprimir Ticket')
                ->icon('heroicon-o-printer')
                ->url(fn() => route('shipments.ticket.view', $this->record)) // Ruta a la impresión
                ->openUrlInNewTab(), // Abre en una nueva pestaña

        ];
    }
}
