<?php

namespace App\Filament\Resources\PackageStatusResource\Pages;

use App\Filament\Resources\PackageStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPackageStatuses extends ListRecords
{
    protected static string $resource = PackageStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
