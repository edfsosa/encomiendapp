<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DriverResource\Pages;
use App\Filament\Resources\DriverResource\RelationManagers;
use App\Models\Driver;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DriverResource extends Resource
{
    protected static ?string $model = Driver::class;
    protected static ?string $label = 'Conductor';
    protected static ?string $pluralLabel = 'Conductores';
    protected static ?string $slug = 'conductores';
    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('ci')
                    ->label('CI')
                    ->maxLength(7)
                    ->minLength(3)
                    ->numeric()
                    ->placeholder('Numero de Cédula')
                    ->required()
                    ->unique(ignoreRecord: true),
                TextInput::make('name')
                    ->label('Conductor')
                    ->maxLength(60)
                    ->minLength(3)
                    ->placeholder('Nombre completo del conductor')
                    ->reactive()
                    ->afterStateUpdated(function (callable $set, $state) {
                        $set('name', strtoupper($state));
                    })
                    ->dehydrated(fn($state) => ! blank($state))
                    ->required(),
                TextInput::make('number_car')
                    ->label('Coche')
                    ->maxLength(5)
                    ->placeholder('Nro. de coche')
                    ->numeric()
                    ->minValue(1)
                    ->reactive()
                    ->afterStateUpdated(function (callable $set, $state) {
                        $set('number_car', strtoupper($state));
                    })
                    ->dehydrated(fn($state) => ! blank($state))
                    ->required()
                    ->unique(ignoreRecord: true),
                TextInput::make('license_plate')
                    ->label('Chapa')
                    ->maxLength(10)
                    ->placeholder('Chapa del coche')
                    ->reactive()
                    ->afterStateUpdated(function (callable $set, $state) {
                        $set('license_plate', strtoupper($state));
                    })
                    ->required(),
                TextInput::make('brand')
                    ->label('Marca')
                    ->maxLength(20)
                    ->placeholder('Marca del coche')
                    ->reactive()
                    ->afterStateUpdated(function (callable $set, $state) {
                        $set('brand', strtoupper($state));
                    })
                    ->required(),
                TextInput::make('model')
                    ->label('Modelo')
                    ->maxLength(20)
                    ->placeholder('Modelo del coche')
                    ->reactive()
                    ->afterStateUpdated(function (callable $set, $state) {
                        $set('model', strtoupper($state));
                    })
                    ->required(),
                Toggle::make('is_active')
                    ->label('Activo')
                    ->hiddenOn('create')
                    ->default(true),
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
                    ->label('Chofer')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('ci')
                    ->label('Cédula')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('number_car')
                    ->label('Nro. Coche')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('license_plate')
                    ->label('Chapa')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('brand')
                    ->label('Marca')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('model')
                    ->label('Modelo')
                    ->sortable()
                    ->searchable(),
                IconColumn::make('is_active')
                    ->label('Activo')
                    ->boolean(),
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
            'index' => Pages\ListDrivers::route('/'),
            'create' => Pages\CreateDriver::route('/create'),
            'edit' => Pages\EditDriver::route('/{record}/edit'),
        ];
    }
}
