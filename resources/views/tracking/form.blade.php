<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Rastreo de Envíos | Ruta 10</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <h1 class="mb-4">Rastreo de Envíos</h1>

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form action="{{ route('tracking.search') }}" method="POST" class="card p-4 shadow-sm">
                    @csrf
                    <div class="mb-3">
                        <label for="tracking_number" class="form-label">Número de seguimiento</label>
                        <input type="text" name="tracking_number" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Rastrear Envío</button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>
