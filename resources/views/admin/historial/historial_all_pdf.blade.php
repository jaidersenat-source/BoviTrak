<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Historial Ganado</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size:12px; }
        table { width:100%; border-collapse:collapse; }
        th, td { border:1px solid #ddd; padding:6px; }
        th { background:#f7f7f7; }
    </style>
</head>
<body>
    <h2>Historial Administrativo - Ganado</h2>
    <p>Generado: {{ now()->format('Y-m-d H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Código</th>
                <th>Nombre</th>
                <th>Raza</th>
                <th>Sexo</th>
                <th>Último peso</th>
                <th>Fecha peso</th>
                <th>Vacunas</th>
                <th>Sanitario</th>
                <th>Ceba</th>
                <th>Descendencia</th>
            </tr>
        </thead>
        <tbody>
            @foreach($animals as $animal)
                <tr>
                    <td>{{ $animal->id }}</td>
                    <td>{{ $animal->codigo_nfc ?? '-' }}</td>
                    <td>{{ $animal->nombre ?? '-' }}</td>
                    <td>{{ $animal->raza ?? '-' }}</td>
                    <td>{{ ucfirst($animal->sexo ?? '-') }}</td>
                    <td>{{ $animal->latestWeight ? $animal->latestWeight->weight.' kg' : '-' }}</td>
                    <td>{{ $animal->latestWeight ? $animal->latestWeight->measured_at->format('Y-m-d') : '-' }}</td>
                    <td>{{ $animal->vaccinations->count() }}</td>
                    <td>{{ $animal->healthRecords->count() }}</td>
                    <td>{{ $animal->cebas->count() }}</td>
                    <td>{{ $animal->asPadre->count() + $animal->asMadre->count() }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
