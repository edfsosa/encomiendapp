<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>{{ $shipment->tracking_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: monospace;
            font-size: 10px;
            width: 164pt;
            /* 58mm */
            padding: 5px;
        }

        .ticket {
            width: 100%;
        }

        .text-center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .line {
            border-top: 1px dashed #000;
            margin: 4px 0;
        }

        .section {
            margin-bottom: 6px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 1px 2px;
            word-wrap: break-word;
        }

        img {
            max-width: 40px;
            height: auto;
            display: block;
            margin: 0 auto 4px auto;
        }

        .signature {
            height: 20px;
            border-bottom: 1px solid #000;
            margin: 4px 0;
        }
    </style>
</head>

<body>
    <div class="ticket">
        <div class="text-center">
            <img src="{{ asset('storage/images/logo.png') }}" alt="Logo">
            <div class="bold">RUTA 10 SRL</div>
            <div>Transporte de cargas</div>
            <div>Carios c/ Av. La Victoria</div>
            <div>Asunción, Paraguay</div>
            <div>Tel: (021) 123-4567</div>
            <div class="bold">Ticket de Envío</div>
        </div>

        <div class="line"></div>

        <div class="section">
            <div>Tracking: <strong>{{ $shipment->tracking_number }}</strong></div>
            <div>Fecha y hora: {{ $shipment->created_at }}</div>
            <div>Pago: {{ $shipment->payment_status }}</div>
            <div>Transportista: {{ $shipment->driver->name }}</div>
            <div>Vehiculo: {{ $shipment->driver->brand . ' ' . $shipment->driver->model ?? '-' }}</div>
            <div>Obs: {{ $shipment->observation ?? '-' }}</div>
        </div>

        <div class="line"></div>

        <div class="section">
            <div>Remitente: {{ $shipment->customer->name }}</div>
            <div>Origen: {{ $shipment->itinerary->originCity->name ?? '-' }}</div>
            <div>Tel: {{ $shipment->customer->phone }}</div>
        </div>

        <div class="section">
            <div>Destinatario: {{ $shipment->addressee_name }}</div>
            <div>Destino: {{ $shipment->itinerary->destinationCity->name ?? '-' }}</div>
            <div>Tel: {{ $shipment->addressee_phone }}</div>
        </div>

        <div class="line"></div>

        @if ($shipment->items->count())
            <div class="section">
                <table>
                    @foreach ($shipment->items as $item)
                        <tr>
                            <td colspan="2">{{ $item->product->description ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>x{{ $item->quantity }}</td>
                            <td>{{ $item->price }}</td>
                            <td style="text-align: right;">
                                {{ number_format($item->subtotal(), 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @endif

        <div class="line"></div>

        <div class="section">
            <div><strong>Total:</strong> {{ number_format($shipment->totalCost(), 0, ',', '.') }} Gs</div>
        </div>

        <div class="line"></div>

        <div class="section"><br>
            <div class="signature"></div>
            <div class="text-center">Firma</div>
        </div>

        <div class="line"></div>

        <div class="text-center">¡Gracias por la confianza!</div>
    </div>
    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>

</html>
