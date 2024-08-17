<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            text-align: center;
            color: white;
            background-color: black;
        }
        .container {
            padding: 20px;
            max-width: 400px;
            margin: 0 auto;
            border: 1px solid #ddd;
            background-color: #111;
        }
        .title {
            font-size: 24px;
            font-weight: bold;
        }
        .subtitle {
            font-size: 16px;
            color: #ff007f;
        }
        .qr-code {
            margin: 20px 0;
        }
        .info {
            font-size: 14px;
            text-align: left;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="title">CHACO VIBES V2</div>
        <div class="subtitle">La historia continúa donde se inició</div>
        <div class="info">
            <p><strong>Nombre:</strong> {{ $ticket->user->name }}</p>
            <p><strong>CI Nro:</strong> {{ $ticket->user->ci }}</p>
            <p><strong>Fecha:</strong> {{ $ticket->event->date }}</p>
            <p><strong>Lugar:</strong> {{ $ticket->event->location }}</p>
        </div>
    </div>
</body>
</html>