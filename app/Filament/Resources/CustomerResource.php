<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Models\Department;
use App\Models\Customer;
use App\Models\User;
use App\Models\City;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\{Section, TextInput, Select, DatePicker, Textarea, Toggle, Repeater};
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\{TextColumn, IconColumn};
use Filament\Tables\Filters\{SelectFilter, TernaryFilter};
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;
    protected static ?string $label = 'Cliente';
    protected static ?string $pluralLabel = 'Clientes';
    protected static ?string $slug = 'clientes';
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $recordTitleAttribute = 'name';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Datos generales')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nombre')
                            ->placeholder('Nombre del cliente')
                            ->maxLength(60)
                            ->reactive()
                            ->afterStateUpdated(function (callable $set, $state) {
                                if ($state) {
                                    $set('name', strtoupper($state));
                                }
                            })
                            ->required(),
                        Select::make('type')
                            ->label('Tipo')
                            ->placeholder('Seleccione el tipo de cliente')
                            ->options([
                                'Persona física' => 'Persona física',
                                'Persona jurídica' => 'Persona jurídica',
                            ])
                            ->reactive()
                            ->afterStateUpdated(function (callable $set, $state) {
                                if ($state === 'Persona jurídica') {
                                    $set('document_type', 'RUC');
                                } else {
                                    $set('document_type', 'CI');
                                }
                            })
                            ->required(),
                        Select::make('document_type')
                            ->label('Tipo Documento')
                            ->placeholder('Seleccione el tipo de documento')
                            ->options([
                                'CI' => 'CI',
                                'RUC' => 'RUC',
                            ])
                            ->reactive()
                            ->afterStateUpdated(function (callable $set, $state) {
                                if ($state === 'RUC') {
                                    $set('document_number', null);
                                }
                            })
                            ->required(),
                        TextInput::make('document_number')
                            ->label('Nro. Documento')
                            ->placeholder('Número de documento')
                            ->numeric()
                            ->minValue(1)
                            ->maxLength(20)
                            ->required()
                            ->unique(ignoreRecord: true),
                    ])->columns(4),

                Section::make('Información de contacto')
                    ->schema([
                        TextInput::make('fantasy_name')
                            ->label('Nombre de Fantasía')
                            ->maxLength(60)
                            ->placeholder('Nombre de fantasía del cliente')
                            ->reactive()
                            ->afterStateUpdated(function (callable $set, $state) {
                                if ($state) {
                                    $set('fantasy_name', strtoupper($state));
                                }
                            })
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
                        TextInput::make('phone_alt')
                            ->label('Teléfono 2')
                            ->placeholder('Alternativo (sin el cero)')
                            ->numeric()
                            ->minLength(8)
                            ->maxLength(11)
                            ->prefix('+595'),
                        TextInput::make('email')
                            ->label('Email')
                            ->placeholder('Correo electrónico del cliente')
                            ->email()
                            ->maxLength(50)
                            ->reactive()
                            ->afterStateUpdated(function (callable $set, $state) {
                                if ($state) {
                                    $set('email', strtolower($state));
                                }
                            })
                            ->required(),
                        Toggle::make('is_gov_supplier')
                            ->label('¿Es Proveedor del Estado?')
                            ->inline(false)
                            ->reactive()
                            ->afterStateUpdated(function (callable $set, $state) {
                                if ($state) {
                                    $set('is_gov_supplier', true);
                                } else {
                                    $set('is_gov_supplier', false);
                                }
                            })
                            ->default(false)
                            ->required(),
                        Select::make('operation_type')
                            ->label('Tipo de Operación')
                            ->placeholder('Seleccione el tipo de operación')
                            ->options([
                                'B2B' => 'B2B',
                                'B2C' => 'B2C',
                                'B2G' => 'B2G',
                                'B2F' => 'B2F',
                            ])
                            ->required(),
                        Repeater::make('addresses')
                            ->relationship('addresses')
                            ->label('Direcciones')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nombre')
                                    ->placeholder('Nombre (casa, oficina, etc.)')
                                    ->maxLength(60)
                                    ->required(),
                                TextInput::make('house_number')
                                    ->label('Nro. Casa')
                                    ->placeholder('Número de la casa')
                                    ->numeric()
                                    ->minValue(1)
                                    ->maxLength(5)
                                    ->required(),
                                TextInput::make('address')
                                    ->label('Dirección')
                                    ->placeholder('Dirección del domicilio')
                                    ->maxLength(100)
                                    ->reactive()
                                    ->afterStateUpdated(function (callable $set, $state) {
                                        if ($state) {
                                            $set('address', strtoupper($state));
                                        }
                                    })
                                    ->required(),
                                Select::make('department_id')
                                    ->label('Departamento')
                                    ->placeholder('Seleccione el departamento')
                                    ->options(Department::all()->pluck('name', 'id'))
                                    ->reactive()
                                    ->searchable()
                                    ->preload()
                                    ->live()
                                    ->loadingMessage('Cargando departamentos...')
                                    ->noSearchResultsMessage('No se encontraron departamentos')
                                    ->searchDebounce(500)
                                    ->native(false)
                                    ->required(),

                                Select::make('city_id')
                                    ->label('Ciudad')
                                    ->placeholder('Seleccione la ciudad')
                                    ->options(function (Get $get) {
                                        $deptId = $get('department_id');
                                        if (!$deptId) return [];

                                        return City::where('department_id', $deptId)->pluck('name', 'id');
                                    })
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->live()
                                    ->loadingMessage('Cargando ciudades...')
                                    ->noSearchResultsMessage('No se encontraron ciudades')
                                    ->searchDebounce(500)
                                    ->native(false)
                                    ->reactive(),
                                TextInput::make('postal_code')
                                    ->label('Código Postal')
                                    ->placeholder('Código postal del domicilio')
                                    ->numeric()
                                    ->minValue(1)
                                    ->maxLength(10)
                                    ->required(),
                            ])
                            ->columns(3)
                            ->columnSpanFull()
                            ->collapsible()
                            ->collapsed()
                            ->minItems(1)
                            ->maxItems(3)
                            ->itemLabel(fn(array $state): ?string => $state['name'] ?? null),
                    ])->columns(3),

                Section::make('Términos comerciales')
                    ->schema([
                        Select::make('agent_id')
                            ->label('Agente')
                            ->placeholder('Seleccione el agente')
                            ->options(function () {
                                return User::where('position', 'Agente')
                                    ->pluck('name', 'id');
                            })
                            ->searchable()
                            ->preload()
                            ->live()
                            ->loadingMessage('Cargando agentes...')
                            ->noSearchResultsMessage('No se encontraron agentes')
                            ->searchDebounce(500)
                            ->native(false)
                            ->required(),
                        TextInput::make('group')
                            ->label('Grupo')
                            ->placeholder('Grupo del cliente'),
                        Select::make('series')
                            ->label('Serie')
                            ->placeholder('Seleccione la serie')
                            ->options([
                                'Ticket' => 'Ticket',
                            ])
                            ->required(),
                        Select::make('payment_method')
                            ->label('Forma de pago')
                            ->placeholder('Seleccione la forma de pago')
                            ->options([
                                'Contado' => 'Contado',
                                'Crédito' => 'Crédito',
                                'Cobrar destino' => 'Cobrar destino',
                            ])
                            ->required(),
                        TextInput::make('payment_days')
                            ->label('Día de pago')
                            ->placeholder('Día de pago (1,15,31)')
                            ->numeric()
                            ->minValue(1)
                            ->maxLength(2)
                            ->required(),
                        Textarea::make('notes')
                            ->label('Observaciones')
                            ->placeholder('Observaciones o notas del cliente')
                            ->rows(1)
                            ->maxLength(500)
                            ->reactive()
                            ->afterStateUpdated(function (callable $set, $state) {
                                if ($state) {
                                    $set('notes', strtoupper($state));
                                }
                            })
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('fantasy_name')
                    ->label('Nombre Fantasía')
                    ->searchable(),
                TextColumn::make('document_number')
                    ->label('Doc.')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('phone')
                    ->label('Teléfono')
                    ->searchable()
                    ->sortable()
                    ->prefix('+595'),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->url(fn(Customer $record): string => 'mailto:' . $record->email)
                    ->openUrlInNewTab(),
                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([])
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
