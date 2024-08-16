<!DOCTYPE html>
<html>
<head>
    <title>
        Datos del usuario registrado con tu compra
    </title>
</head>
<body>
    <h1>Gracias por la compra!</h1>
    <p>Aqui estan los detalles del usuario registrado con tu compra:</p>
    <p><strong>Nombre:</strong> {{ $user->name }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Contraseña:</strong> {{ $user->password }}</p>
</body>
</html>