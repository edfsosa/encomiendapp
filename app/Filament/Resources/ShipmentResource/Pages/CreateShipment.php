<?php

namespace App\Filament\Resources\ShipmentResource\Pages;

use App\Filament\Resources\ShipmentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateShipment extends CreateRecord
{
    protected static string $resource = ShipmentResource::class;

    // Este metodo es para agregar acciones al formulario después de crear el envío
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();
        $data['package_status_id'] = 1; // Assuming 1 is the ID for 'Pending' status

        return $data;
    }
    
    // Este metodo es para redirigir a la vista del ticket después de crear el envío
    protected function getRedirectUrl(): string
    {
        return route('shipments.ticket.view', $this->record);
    }
}
