<?php

namespace App\Filament\Resources\PackageStatusResource\Pages;

use App\Filament\Resources\PackageStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPackageStatus extends EditRecord
{
    protected static string $resource = PackageStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
