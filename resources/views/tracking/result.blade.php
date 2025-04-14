<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Detalle del Envío | Ruta 10</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-white">

    <div class="container py-5">
        <div class="text-center mb-4">
            <h2>📦 Detalles del Envío</h2>
            <p class="text-muted">Seguimiento de tu paquete</p>
        </div>

        <div class="card shadow-sm p-4">
            <h5 class="text-primary mb-3">Envío Nº: {{ $shipment->tracking_number }}</h5>

            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Fecha de envío:</strong> {{ $shipment->shipment_date }}
                </div>
                <div class="col-md-6">
                    <strong>Estado del Envío:</strong> {{ $shipment->packageStatus->name ?? 'N/A' }}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Estado de Pago:</strong> {{ $shipment->payment_status }}
                </div>
                <div class="col-md-6">
                    <strong>Método de Pago:</strong> {{ $shipment->payment_method }}
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-6">
                    <h6>🔹 Enviado por</h6>
                    <p>
                        {{ $shipment->customer->name }}<br>
                        {{ $shipment->itinerary->originCity->name }}
                        
                    </p>
                </div>

                <div class="col-md-6">
                    <h6>🔸 Recibe</h6>
                    <p>
                        {{ $shipment->addressee_name }}<br>
                        {{ $shipment->addressee_address }}<br>
                        Tel: {{ $shipment->addressee_phone }}<br>
                        Email: {{ $shipment->addressee_email }}
                    </p>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
