<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PermissionResource\Pages;
use App\Filament\Resources\PermissionResource\RelationManagers;
use App\Filament\Traits\HasResourcePermissions;
use App\Models\Permission;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Spatie\Permission\Models\Permission as ModelsPermission;

class PermissionResource extends Resource
{
    use HasResourcePermissions;

    protected static ?string $model = ModelsPermission::class;
    protected static ?string $navigationGroup = 'Administración';
    protected static ?string $navigationLabel = 'Permisos';
    protected static ?string $label = 'Permiso';
    protected static ?string $pluralLabel = 'Permisos';
    protected static ?string $slug = 'permisos';
    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Permiso')
                    ->placeholder('Nombre del permiso')
                    ->maxLength(50)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Permiso')
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
            'index' => Pages\ListPermissions::route('/'),
            'create' => Pages\CreatePermission::route('/create'),
            'edit' => Pages\EditPermission::route('/{record}/edit'),
        ];
    }
}
