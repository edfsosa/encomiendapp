<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShipmentResource\Pages;
use App\Filament\Resources\ShipmentResource\RelationManagers;
use App\Models\Shipment;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ShipmentResource extends Resource
{
    protected static ?string $model = Shipment::class;
    protected static ?string $label = 'Envio';
    protected static ?string $pluralLabel = 'Envios';
    protected static ?string $slug = 'envios';
    protected static ?string $navigationIcon = 'heroicon-o-cube';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Datos del envío')
                    ->schema([
                        TextInput::make('tracking_number')
                            ->label('Tracking ID')
                            ->disabled()
                            ->dehydrated()
                            ->hiddenOn('create')
                            ->required(),
                        DatePicker::make('shipment_date')
                            ->label('Fecha de envío')
                            ->placeholder('Selecciona una fecha')
                            ->native(false)
                            ->closeOnDateSelection()
                            ->displayFormat('d/m/Y')
                            ->default(now())
                            ->required(),
                        Select::make('package_status_id')
                            ->label('Estado del envío')
                            ->placeholder('Selecciona un estado')
                            ->relationship('packageStatus', 'name')
                            ->searchable()
                            ->preload()
                            ->hiddenOn('create')
                            ->required(),
                        Select::make('payment_status')
                            ->label('Estado de pago')
                            ->options([
                                'Pendiente' => 'Pendiente',
                                'Pagado' => 'Pagado',
                                'Parcial' => 'Parcial',
                            ])
                            ->required(),
                        select::make('user_id')
                            ->label('Usuario')
                            ->relationship('user', 'name')
                            ->disabled()
                            ->dehydrated()
                            ->hiddenOn('create')
                            ->required(),
                    ])->columns(3),

                Section::make('Cliente e itinerario')
                    ->schema([
                        Select::make('customer_id')
                            ->label('Cliente')
                            ->relationship('customer', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('itinerary_id')
                            ->label('Itinerario')
                            ->relationship('itinerary', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('driver_id')
                            ->label('Conductor')
                            ->relationship('driver', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('payment_method')
                            ->label('Método de pago')
                            ->options([
                                'Contado' => 'Contado',
                                'Crédito' => 'Crédito',
                                'Cobrar destino' => 'Cobrar destino',
                            ])
                            ->searchable()
                            ->preload()
                            ->required(),
                    ])->columns(2),

                Section::make('Destinatario')
                    ->schema([
                        TextInput::make('addressee_name')
                            ->label('Nombre completo')
                            ->placeholder('Nombre y apellido del destinatario')
                            ->maxLength(60)
                            ->reactive()
                            ->afterStateUpdated(fn($set, $state) => $set('addressee_name', strtoupper($state)))
                            ->required(),

                        TextInput::make('addressee_address')
                            ->label('Dirección')
                            ->placeholder('Dirección de entrega')
                            ->maxLength(100)
                            ->reactive()
                            ->afterStateUpdated(fn($set, $state) => $set('addressee_address', strtoupper($state)))
                            ->required(),

                        TextInput::make('addressee_phone')
                            ->label('Teléfono')
                            ->placeholder('Número sin el cero inicial')
                            ->prefix('+595')
                            ->numeric()
                            ->minLength(8)
                            ->maxLength(11)
                            ->required(),

                        TextInput::make('addressee_email')
                            ->label('Email')
                            ->placeholder('Correo electrónico')
                            ->email()
                            ->maxLength(60)
                            ->reactive()
                            ->afterStateUpdated(fn($set, $state) => $set('addressee_email', strtolower($state))),
                    ])->columns(2),

                Section::make('Productos del envío')
                    ->schema([
                        Repeater::make('items')
                            ->relationship()
                            ->schema([
                                Select::make('product_id')
                                    ->label('Producto')
                                    ->options(Product::pluck('description', 'id'))
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                        $price = Product::find($state)?->price ?? 0;
                                        $set('price', $price);
                                    }),

                                TextInput::make('quantity')
                                    ->label('Cantidad')
                                    ->numeric()
                                    ->default(1)
                                    ->required()
                                    ->reactive(),


                                TextInput::make('price')
                                    ->label('Precio Unitario')
                                    ->numeric()
                                    ->readOnly()
                                    ->dehydrated(true) // esto es lo importante
                                    ->required(),



                                Placeholder::make('subtotal')
                                    ->label('Subtotal')
                                    ->content(function (callable $get) {
                                        $price = $get('price') ?? 0;
                                        $quantity = $get('quantity') ?? 0;
                                        return number_format($price * $quantity, 0, ',', '.') . ' Gs';
                                    }),
                            ])
                            ->defaultItems(1)
                            ->columns(4),

                    ]),


                Section::make('Resumen del envío')
                    ->schema([
                        // Totales
                        Placeholder::make('total_items')
                            ->label('Total Ítems')
                            ->content(fn(?Shipment $record) => $record?->totalItems() ?? 0),

                        Placeholder::make('total_cost')
                            ->label('Total Costo')
                            ->content(fn(?Shipment $record) => $record?->formattedTotalCost() ?? '0'),
                        Textarea::make('observation')
                            ->label('Observaciones')
                            ->maxLength(500)
                            ->reactive()
                            ->placeholder('Observaciones del envío')
                            ->afterStateUpdated(fn($set, $state) => $set('observation', strtoupper($state))),
                    ])->columns(3),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tracking_number')
                    ->label('Tracking ID')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('shipment_date')
                    ->label('Fecha de envío')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('customer.name')
                    ->label('Cliente')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('addressee_name')
                    ->label('Destinatario')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('payment_method')
                    ->label('Método de pago')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('packageStatus.name')
                    ->label('Estado del envío')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('user.name')
                    ->label('Usuario')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Creado')
                    ->sortable()
                    ->dateTime(),
                TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->sortable()
                    ->dateTime(),
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
            'index' => Pages\ListShipments::route('/'),
            'create' => Pages\CreateShipment::route('/create'),
            'edit' => Pages\EditShipment::route('/{record}/edit'),
        ];
    }
}
