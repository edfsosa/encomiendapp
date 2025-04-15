<?php

namespace App\Filament\Pages;

use App\Filament\Traits\HasResourcePermissions;
use App\Models\Shipment;
use App\Models\Customer;
use App\Models\Product;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;


class Reports extends Page implements HasTable
{
    use HasResourcePermissions;
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-document';

    protected static string $view = 'filament.pages.reports';

    protected function getTableQuery()
    {
        return Shipment::query()->with(['customer', 'driver', 'user', 'items.product']);
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('shipment_date')
                ->label('Fecha')
                ->sortable(),
            TextColumn::make('tracking_number')
                ->label('Tracking ID')
                ->searchable()
                ->sortable(),
            TextColumn::make('customer.name')
                ->label('Cliente')
                ->searchable()
                ->sortable(),
            TextColumn::make('addressee_name')
                ->label('Destinatario')
                ->searchable()
                ->sortable(),
            TextColumn::make('driver.name')
                ->label('Conductor')
                ->searchable()
                ->sortable(),
            TextColumn::make('total_items')
                ->label('Total Ítems')
                ->getStateUsing(fn($record) => $record->totalItems())
                ->sortable(),
            TextColumn::make('total_cost')
                ->label('Costo Total')
                ->getStateUsing(fn($record) => number_format($record->totalCost(), 0, ',', '.') . ' Gs')
                ->sortable(),
            TextColumn::make('payment_method')
                ->label('Método pago')
                ->searchable()
                ->sortable(),
            TextColumn::make('user.name')
                ->label('Usuario')
                ->searchable()
                ->sortable(),
        ];
    }

    protected function getTableFilters(): array
    {
        return [
            SelectFilter::make('customer_id')
                ->label('Cliente')
                ->relationship('customer', 'name'),

            SelectFilter::make('driver_id')
                ->label('Conductor')
                ->relationship('driver', 'name'),

            Filter::make('Fecha')
                ->form([
                    DatePicker::make('from')->label('Desde'),
                    DatePicker::make('until')->label('Hasta'),
                ])
                ->query(function ($query, array $data) {
                    return $query
                        ->when($data['from'], fn($q) => $q->whereDate('shipment_date', '>=', $data['from']))
                        ->when($data['until'], fn($q) => $q->whereDate('shipment_date', '<=', $data['until']));
                }),
            SelectFilter::make('items.product_id')
                ->label('Producto')
                ->relationship('items.product', 'description'),

        ];
    }
}
