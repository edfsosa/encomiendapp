<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransportFormResource\Pages;
use App\Filament\Resources\TransportFormResource\RelationManagers;
use App\Models\TransportForm;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransportFormResource extends Resource
{
    protected static ?string $model = TransportForm::class;
    protected static ?string $label = 'Forma de Transporte';
    protected static ?string $pluralLabel = 'Formas de Transporte';
    protected static ?string $slug = 'forma-transporte';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $recordTitleAttribute = 'description';

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
                    ->placeholder('Ej: PAQUETE, BOLSA, CAJA')
                    ->required()
                    ->maxLength(50),
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
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->dateTime()
                    ->sortable(),
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
            'index' => Pages\ListTransportForms::route('/'),
            'create' => Pages\CreateTransportForm::route('/create'),
            'edit' => Pages\EditTransportForm::route('/{record}/edit'),
        ];
    }
}
