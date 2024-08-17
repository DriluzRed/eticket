<!DOCTYPE html>
<html>
<head>
    <title>Confirmacion de compra de entrada para el evento {{$ticket->event->name}}</title>
</head>
<body>
    <h1>Gracias por la compra!</h1>
    <p>Aqui estan los detalles de tu entrada:</p>
    <h2>Asignado a:</h2>
    <p><strong>Nombre:</strong> {{ $ticket->user->name }}</p>
    <p><strong>Correo electronico:</strong> {{ $ticket->user->email }}</p>
    <p><strong>Evento:</strong> {{ $ticket->event->name }}</p>
    <p><strong>Tipo de entrada:</strong> {{ $ticket->ticketType->name }}</p>
    <p><strong>Codigo QR:</strong></p>
    <p>Por favor, presenta este codigo QR en la entrada del evento.</p>
</body>
</html>