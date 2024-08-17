@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Escanear codigo QR</h1>
                <video id="qr-reader" style="width:100%;"></video>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    <script>
        let scanner = new Instascan.Scanner({ video: document.getElementById('qr-reader') });
        scanner.addListener('scan', function (content) {
            $.ajax({
                url: '/check',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    qr_code: content
                },
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            title: 'Datos del código QR',
                            text: 'Nombre: ' + response.data.name + ', CI: ' + response.data.ci,
                            icon: 'success',
                            confirmButtonText: 'Confirmar'
                        });
                    }else if(response.warning){
                        Swal.fire({
                            title: 'Ticket ya utilizado',
                            text: 'El ticket ya fue utilizado',
                            icon: 'info',
                            confirmButtonText: 'Confirmar'
                        });
                    }
                    else {
                        Swal.fire({
                            title: 'Error',
                            text: 'Error al leer el código QR o el ticket no existe',
                            icon: 'error',
                            confirmButtonText: 'Confirmar'
                        });
                    }
                }
            });
        });
        Instascan.Camera.getCameras().then(function (cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);
            } else {
                console.error('No se encontró cámara en el dispositivo.');
            }
        }).catch(function (e) {
            console.error(e);
        });
    </script>
@endsection