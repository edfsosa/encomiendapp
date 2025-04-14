<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ticket de Envío</title>
    <style>
        @media print {
            body {
                width: 58mm;
                font-family: monospace;
                font-size: 12px;
                margin: 0;
            }

            .ticket {
                padding: 10px;
            }

            .text-center {
                text-align: center;
            }

            .bold {
                font-weight: bold;
            }

            .line {
                border-top: 1px dashed black;
                margin: 5px 0;
            }

            .section {
                margin-bottom: 8px;
            }
        }

        body {
            font-family: monospace;
            font-size: 12px;
        }

        .ticket {
            width: 58mm;
            padding: 10px;
        }

        .text-center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .line {
            border-top: 1px dashed black;
            margin: 5px 0;
        }

        .section {
            margin-bottom: 8px;
        }
    </style>
</head>

<body>
    <div class="ticket">
        <div class="text-center">
            <img src="{{ asset('storage/images/logo.png') }}" alt="Logo" style="width: 50px; height: auto;">
        </div>
        
        <div class="text-center bold">RUTA 10 SRL</div>
        <div class="text-center">Transporte de cargas y encomiendas</div>
        <div class="text-center">Carios c/ Av. La Victoria</div>
        <div class="text-center">Asunción, Paraguay</div>
        <div class="text-center">Tel: (021) 123-4567</div>
        <div class="text-center">RUC: 12345678-9</div>
        <div class="text-center">Ticket de Envío</div>
        <div class="line"></div>

        <div class="section">
            <strong>Tracking:</strong> {{ $shipment->tracking_number }}<br>
            <strong>Fecha:</strong> {{ $shipment->shipment_date }}<br>
            <strong>Pago:</strong> {{ $shipment->payment_status }} / {{ $shipment->payment_method }}<br>
            <strong>Agente:</strong> {{ $shipment->user->name ?? '-' }}<br>
            <strong>Conductor:</strong> {{ $shipment->driver->name ?? '-' }}<br>
            <strong>Vehículo:</strong> {{ $shipment->driver->brand . ' ' . $shipment->driver->model ?? '-' }}<br>
            <strong>N° Chapa:</strong> {{ $shipment->driver->license_plate ?? '-' }}<br>
        </div>

        <div class="line"></div>

        <div class="section">
            <strong>Remitente:</strong> {{ $shipment->customer->name }}<br>
            <strong>Origen:</strong> {{ $shipment->itinerary->originCity->name ?? '-' }}<br>
            <strong>Teléfono:</strong> {{ $shipment->customer->phone }}<br>
        </div>

        <div class="line"></div>

        <div class="section">
            <strong>Destinatario:</strong> {{ $shipment->addressee_name }}<br>
            <strong>Destino:</strong> {{ $shipment->itinerary->destinationCity->name ?? '-' }}<br>
            <strong>Dirección:</strong> {{ $shipment->addressee_address }}<br>
            <strong>Teléfono:</strong> {{ $shipment->addressee_phone }}<br>
        </div>

        <div class="line"></div>

        @if ($shipment->shipmentItems->count())
            <div class="section">
                <strong>Detalle de Productos:</strong>
                <table width="100%">
                    <thead>
                        <tr>
                            <td><strong>Desc</strong></td>
                            <td><strong>Cant</strong></td>
                            <td><strong>Unit</strong></td>
                            <td><strong>Subtotal</strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($shipment->shipmentItems as $item)
                            <tr>
                                <td>{{ $item->product->description ?? '-' }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->product->price, 0, ',', '.') }}</td>
                                <td>{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="line"></div>
        @endif

        <div class="section">
            <strong>Total Ítems:</strong> {{ $shipment->total_items }}<br>
            <strong>Total Costo:</strong> {{ number_format($shipment->total_cost, 0, ',', '.') }} Gs
        </div>

        <div class="line"></div>

        <div class="section">
            <strong>Recibido por:</strong><br>
            <div style="height: 50px; border-bottom: 1px solid black;"></div>
            <div style="text-align: center;">Firma</div>

            <strong>Entregado por:</strong>
            <div style="height: 50px; border-bottom: 1px solid black;"></div>
            <div style="text-align: center;">Firma</div>

        </div>

        <div class="line"></div>
        <div class="text-center">¡Gracias por confiar en nosotros!</div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>

</html>
