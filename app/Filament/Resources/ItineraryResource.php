<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ItineraryResource\Pages;
use App\Filament\Resources\ItineraryResource\RelationManagers;
use App\Filament\Traits\HasResourcePermissions;
use App\Models\Itinerary;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ItineraryResource extends Resource
{
    use HasResourcePermissions;

    protected static ?string $model = Itinerary::class;
    protected static ?string $label = 'Itinerario';
    protected static ?string $pluralLabel = 'Itinerarios';
    protected static ?string $slug = 'itinerarios';
    protected static ?string $navigationIcon = 'heroicon-o-map';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('id')
                    ->label('ID')
                    ->disabled()
                    ->hiddenOn('create')
                    ->required(),
                TextInput::make('name')
                    ->label('Nombre')
                    ->placeholder('Nombre del itinerario')
                    ->hiddenOn('create')
                    ->disabled()
                    ->dehydrated()
                    ->reactive()
                    ->required(),
                Select::make('agency_id')
                    ->label('Agencia')
                    ->relationship('agency', 'name')
                    ->searchable()
                    ->preload()
                    ->live()
                    ->native(false)
                    ->required(),
                Select::make('origin_city_id')
                    ->label('Origen')
                    ->placeholder('Seleccione el origen')
                    ->relationship('originCity', 'name')
                    ->searchable()
                    ->preload()
                    ->live()
                    ->native(false)
                    ->required(),
                Select::make('destination_city_id')
                    ->label('Destino')
                    ->placeholder('Seleccione el destino')
                    ->relationship('destinationCity', 'name')
                    ->searchable()
                    ->preload()
                    ->live()
                    ->native(false)
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Nombre')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('agency.name')
                    ->label('Agencia')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('originCity.name')
                    ->label('Origen')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('destinationCity.name')
                    ->label('Destino')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Creado')
                    ->sortable()
                    ->dateTime(),
                TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->sortable()
                    ->dateTime()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListItineraries::route('/'),
            'create' => Pages\CreateItinerary::route('/create'),
            'edit' => Pages\EditItinerary::route('/{record}/edit'),
        ];
    }
}
