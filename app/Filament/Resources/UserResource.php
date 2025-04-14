<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationGroup = 'Administración';
    protected static ?string $navigationLabel = 'Usuarios';
    protected static ?string $label = 'Usuario';
    protected static ?string $pluralLabel = 'Usuarios';
    protected static ?string $slug = 'usuarios';
    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('ci')
                    ->label('Cédula')
                    ->placeholder('Ingresá el número de cédula')
                    ->required()
                    ->maxLength(7)
                    ->numeric()
                    ->minValue(1)
                    ->unique(ignoreRecord: true)
                    ->dehydrated(fn($state) => !empty($state))
                    ->reactive(),
                TextInput::make('name')
                    ->label('Nombre completo')
                    ->placeholder('Ingresá tu nombre completo')
                    ->required()
                    ->maxLength(60),
                TextInput::make('email')
                    ->label('Correo electrónico')
                    ->placeholder('Ingresá tu correo electrónico')
                    ->required()
                    ->email()
                    ->maxLength(60),
                TextInput::make('password')
                    ->password()
                    ->required()
                    ->confirmed()
                    ->maxLength(255)
                    ->dehydrated(fn($state) => !empty($state))
                    ->visible(fn($record) => $record === null),
                TextInput::make('phone')
                    ->label('Teléfono')
                    ->placeholder('Número (sin el cero)')
                    ->numeric()
                    ->minValue(1)
                    ->minLength(8)
                    ->maxLength(11)
                    ->prefix('+595')
                    ->required(),
                TextInput::make('position')
                    ->label('Cargo')
                    ->placeholder('Ingresá el cargo o posición')
                    ->required()
                    ->maxLength(60),
                TextInput::make('area')
                    ->label('Área')
                    ->placeholder('Ingresá el área o departamento')
                    ->required()
                    ->maxLength(60),
                Select::make('agency_id')
                    ->label('Agencia')
                    ->placeholder('Seleccioná una agencia')
                    ->relationship('agency', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('roles')
                    ->label('Rol')
                    ->relationship('roles', 'name')
                    ->preload()
                    ->searchable()
                    ->required()
                    ->placeholder('Seleccioná un rol')
                    ->native(false),
                Toggle::make('is_active')
                    ->label('Estado')
                    ->required()
                    ->inline()
                    ->onColor('success')
                    ->offColor('danger')
                    ->onIcon('heroicon-o-check-circle')
                    ->offIcon('heroicon-o-x-circle')
                    ->hiddenOn('create'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('ci')
                    ->label('CI')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('email')
                    ->label('Correo electrónico')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->url(fn($record) => 'mailto:' . $record->email)
                    ->openUrlInNewTab(),
                TextColumn::make('phone')
                    ->label('Teléfono')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->prefix('+595'),
                TextColumn::make('position')
                    ->label('Cargo')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('area')
                    ->label('Área')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('agency.name')
                    ->label('Agencia')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('roles.name')
                    ->label('Rol')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                ToggleColumn::make('is_active')
                    ->label('Estado')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->dateTime()
                    ->sortable()
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
