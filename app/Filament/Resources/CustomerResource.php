<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\{Section, TextInput, Select, DatePicker, Textarea, Toggle};
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
    protected static ?string $navigationGroup = 'Clientes';
    protected static ?string $navigationLabel = 'Clientes';
    protected static ?string $label = 'Cliente';
    protected static ?string $pluralLabel = 'Clientes';
    protected static ?string $slug = 'clientes';
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $searchLabel = 'Buscar';
    protected static ?string $searchPlaceholder = 'Buscar cliente...';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Datos generales')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nombre')
                            ->placeholder('Nombre del cliente')
                            ->maxLength(50)
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
                            ->maxLength(50)
                            ->reactive()
                            ->afterStateUpdated(function (callable $set, $state) {
                                if ($state) {
                                    $set('fantasy_name', strtoupper($state));
                                }
                            })
                            ->required(),
                        TextInput::make('phone')
                            ->label('Teléfono')
                            ->maxLength(20)
                            ->reactive()
                            ->afterStateUpdated(function (callable $set, $state) {
                                if ($state) {
                                    $set('phone', strtoupper($state));
                                }
                            })
                            ->prefix('+595')
                            ->required(),
                        TextInput::make('phone_alt')
                            ->label('Teléfono 2')
                            ->maxLength(20)
                            ->reactive()
                            ->afterStateUpdated(function (callable $set, $state) {
                                if ($state) {
                                    $set('phone_alt', strtoupper($state));
                                }
                            })
                            ->prefix('+595'),
                        TextInput::make('email')
                            ->label('Email')
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
                            ->required(),
                        TextInput::make('address')
                            ->label('Dirección')
                            ->maxLength(100)
                            ->reactive()
                            ->afterStateUpdated(function (callable $set, $state) {
                                if ($state) {
                                    $set('address', strtoupper($state));
                                }
                            })
                            ->required(),
                        TextInput::make('house_number')
                            ->label('Nro. Casa')
                            ->maxLength(20)
                            ->reactive()
                            ->afterStateUpdated(function (callable $set, $state) {
                                if ($state) {
                                    $set('house_number', strtoupper($state));
                                }
                            })
                            ->required(),
                        Select::make('operation_type')
                            ->label('Tipo de Operación')
                            ->options([
                                'B2B' => 'B2B',
                                'B2C' => 'B2C',
                                'B2G' => 'B2G',
                                'B2F' => 'B2F',
                            ])
                            ->reactive()
                            ->afterStateUpdated(function (callable $set, $state) {
                                if ($state === 'B2G') {
                                    $set('is_gov_supplier', true);
                                } else {
                                    $set('is_gov_supplier', false);
                                }
                            })
                            ->required(),
                    ])->columns(3),

                Section::make('Términos comerciales')
                    ->schema([
                        Select::make('agent_id')
                            ->label('Agente')
                            ->searchable()
                            ->preload()
                            ->reactive()
                            ->live(),
                        TextInput::make('group')
                            ->label('Grupo'),
                        Select::make('series')
                            ->label('Serie')
                            ->reactive()
                            ->options([
                                'Ticket' => 'Ticket',
                            ])
                            ->default('Ticket')
                            ->required(),
                        Select::make('payment_method')
                            ->label('Forma de pago')
                            ->reactive()
                            ->options([
                                'Contado' => 'Contado',
                                'Crédito' => 'Crédito',
                                'Cobrar destino' => 'Cobrar destino',
                            ])
                            ->required(),
                        TextInput::make('payment_days')
                            ->label('Días de pago')
                            ->hint('Ejemplo: 1,15,31')
                            ->reactive()
                            ->afterStateUpdated(function (callable $set, $state) {
                                if ($state) {
                                    $set('payment_days', strtoupper($state));
                                }
                            })
                            ->required(),
                    ])->columns(3),

                Section::make('Observaciones')
                    ->schema([
                        Textarea::make('notes')
                            ->label('Observaciones')
                            ->columnSpanFull()
                            ->maxLength(500)
                            ->reactive()
                            ->afterStateUpdated(function (callable $set, $state) {
                                if ($state) {
                                    $set('notes', strtoupper($state));
                                }
                            }),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nombre')->searchable()->sortable(),
                TextColumn::make('fantasy_name')->label('Nombre Fantasía')->searchable(),
                TextColumn::make('document_number')->label('Doc.'),
                TextColumn::make('phone')->label('Teléfono'),
                TextColumn::make('email')->label('Email')->toggleable(),
                TextColumn::make('operation_type')->label('Tipo Op.')->sortable(),
                IconColumn::make('is_gov_supplier')
                    ->label('Proveedor del Estado')
                    ->boolean()
                    ->toggleable(),
                TextColumn::make('created_at_custom')->label('F. Creación')->date()->sortable(),

            ])
            ->filters([
                SelectFilter::make('operation_type')->label('Tipo de Operación')
                    ->options([
                        'B2B' => 'B2B',
                        'B2C' => 'B2C',
                    ]),
                TernaryFilter::make('is_gov_supplier')->label('Proveedor del Estado'),
            ])->defaultSort('created_at_custom', 'desc')
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
