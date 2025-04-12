<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PackageStatusResource\Pages;
use App\Filament\Resources\PackageStatusResource\RelationManagers;
use App\Models\PackageStatus;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PackageStatusResource extends Resource
{
    protected static ?string $model = PackageStatus::class;
    protected static ?string $label = 'Estado';
    protected static ?string $pluralLabel = 'Estados';
    protected static ?string $slug = 'estados';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-group';
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('code')
                    ->label('Código')
                    ->placeholder('Ej: 001')
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(999)
                    ->length(3)
                    ->reactive()
                    ->afterStateUpdated(function (callable $set, $state) {
                        if ($state) {
                            $set('code', str_pad($state, 3, '0', STR_PAD_LEFT));
                        }
                    })
                    ->unique(ignoreRecord: true)
                    ->required(),
                TextInput::make('name')
                    ->label('Nombre de Estado')
                    ->placeholder('Ej: En tránsito')
                    ->maxLength(50)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                ->label('Código de Estado')
                ->sortable()
                ->searchable(),
                TextColumn::make('name')
                ->label('Nombre de Estado')
                ->sortable()
                ->searchable(),
                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->dateTime()
                    ->sortable()
                    ->searchable(),
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
            'index' => Pages\ListPackageStatuses::route('/'),
            'create' => Pages\CreatePackageStatus::route('/create'),
            'edit' => Pages\EditPackageStatus::route('/{record}/edit'),
        ];
    }
}
