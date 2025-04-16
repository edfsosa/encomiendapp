<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AgencyResource\Pages;
use App\Filament\Resources\AgencyResource\RelationManagers;
use App\Filament\Traits\HasResourcePermissions;
use App\Models\Agency;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AgencyResource extends Resource
{
    use HasResourcePermissions;

    protected static ?string $model = Agency::class;
    protected static ?string $label = 'Agencia';
    protected static ?string $pluralLabel = 'Agencias';
    protected static ?string $slug = 'agencias';
    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nombre')
                    ->placeholder('Nombre de la agencia')
                    ->maxLength(50)
                    ->required(),
                TextInput::make('city')
                    ->label('Ciudad')
                    ->placeholder('Ciudad de la agencia')
                    ->maxLength(50)
                    ->required(),
                TextInput::make('address')
                    ->label('Dirección')
                    ->placeholder('Dirección de la agencia')
                    ->maxLength(100)
                    ->required(),
                TextInput::make('phone')
                    ->label('Teléfono')
                    ->placeholder('Número (sin el cero)')
                    ->numeric()
                    ->minValue(1)
                    ->minLength(8)
                    ->maxLength(11)
                    ->prefix('+595')
                    ->required(),
                Forms\Components\Toggle::make('is_active')
                    ->label('Estado')
                    ->hiddenon(['create']),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('Código')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Nombre')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('city')
                    ->label('Ciudad')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('address')
                    ->label('Dirección')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('phone')
                    ->label('Teléfono')
                    ->sortable()
                    ->searchable(),
                ToggleColumn::make('is_active')
                    ->label('Estado')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable()
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
            'index' => Pages\ListAgencies::route('/'),
            'create' => Pages\CreateAgency::route('/create'),
            'edit' => Pages\EditAgency::route('/{record}/edit'),
        ];
    }
}
