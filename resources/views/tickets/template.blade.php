<!DOCTYPE html>
<html>

<head>
    <title>Chaco Vibes V2</title>
    <link rel="stylesheet" href="{{ asset('styles.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Matemasie&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=New+Amsterdam&display=swap" rel="stylesheet">
    <style>
        :root {
            background-color: #000;
        }

        body {
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: black;
            background-image: url('{{ $background }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .pass {
            text-align: center;
            color: white;
            font-family: sans-serif;
        }

        .pass h1 {
            font-family: 'New Amsterdam', sans-serif;
            font-size: 5rem;
            color: #eee6eb;
            margin: 0;
            font-weight: bold;
            -webkit-text-stroke: 1px black;
        }

        .pass h2 {
            font-family: 'New Amsterdam', sans-serif;
            font-size: 1.5rem;
            color: #dd349c;
            text-transform: uppercase;
            /* Alternativa a small-caps */
        }

        /* Agregar estilos para el patrón de fondo si es necesario */
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, rgba(255, 0, 255, 0.2), rgba(0, 255, 255, 0.2));
            background-size: 20px 20px;
            z-index: -1;
        }
        footer {
          text-align: center;
          padding: 10px;
          background: rgba(0, 0, 0, 0.5);
          color: white;
          font-size: 18px;
        }
    </style>
</head>

<body>
    <div class="pass">
        <div class="container">
            <h1 style="margin-top:50px">CHACO</h1>
            <h1>VIBES V3</h1>
            {{-- <h2>La historia continúa donde se inició</h2> --}}
            <div class="qr-code">
                <img src="{{ $qrCodeUri }}" alt="QR Code">
            </div>

            <p style="font-size: 18px;"><strong>Nombre:</strong> {{ $ticket->user->name }}</p>
            <p style="font-size: 18px;"><strong>CI Nro:</strong> {{ $ticket->user->ci }}</p>
            <p style="font-size: 18px;"><strong>Fecha:</strong>
                {{ \Carbon\Carbon::parse($ticket->event->event_date)->format('d-m-Y') }}</p>
            <p style="font-size: 18px;"><strong>Lugar:</strong> {{ $ticket->event->city->name }}</p>
            
        </div>
    </div>
    <footer>
      <div>
        @if ($ticket->ticketType->is_courtesy == 1)
          <p style="font-size: 18px;"><strong>{{ $ticket->ticketType->description }}</strong></p>
        @endif
      </div>
    </footer>
</body>

</html>
