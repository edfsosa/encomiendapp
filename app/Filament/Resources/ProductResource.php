<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $label = 'Producto';
    protected static ?string $pluralLabel = 'Productos';
    protected static ?string $slug = 'productos';
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('id')
                    ->label('ID')
                    ->disabled()
                    ->hiddenOn('create')
                    ->required(),
                TextInput::make('description')
                    ->label('Descripción')
                    ->placeholder('Descripción del producto o servicio')
                    ->maxLength(60)
                    ->reactive()
                    ->afterStateUpdated(function (callable $set, $state) {
                        if ($state) {
                            $set('description', strtoupper($state));
                        }
                    })
                    ->required(),
                Select::make('tax')
                    ->label('Impuesto')
                    ->placeholder('Seleccione un impuesto')
                    ->reactive()
                    ->options([
                        'IVA 10%' => 'IVA 10%',
                        'IVA 5%' => 'IVA 5%',
                        'EXENTO' => 'Exento',
                    ])
                    ->required(),
                Select::make('type')
                    ->label('Tipo')
                    ->placeholder('Seleccione un tipo')
                    ->reactive()
                    ->options([
                        'NORMAL' => 'Normal',
                        'SEGUNDA MANO' => 'Segunda Mano',
                        'SERVICIO' => 'Servicio',
                        'VIAJE' => 'Viaje',
                    ])
                    ->required(),
                TextInput::make('price')
                    ->label('Precio')
                    ->placeholder('Precio del producto o servicio')
                    ->integer()
                    ->minValue(0)
                    ->maxValue(9999999)
                    ->prefix('Gs.')
                    ->required(),
                Toggle::make('is_active')
                    ->label('Activo')
                    ->default(true)
                    ->inline(false)
                    ->required()
                    ->hiddenOn('create'),
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
                TextColumn::make('description')
                    ->label('Descripción')
                    ->sortable()
                    ->searchable()
                    ->limit(30),
                TextColumn::make('type')
                    ->label('Tipo')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('price')
                    ->label('Precio')
                    ->sortable()
                    ->searchable()
                    ->money('PYG', true),
                TextColumn::make('tax')
                    ->label('Impuesto')
                    ->sortable()
                    ->searchable(),
                ToggleColumn::make('is_active')
                    ->label('Activo')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
