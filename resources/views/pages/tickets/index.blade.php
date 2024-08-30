@extends('layouts.app')
@section('content_header')
    <h1>Tickets</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('tickets.create') }}" class="btn btn-primary">Emitir Tickets</a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Persona asignada</th>
                        <th>Evento</th>
                        <th>Fecha de compra</th>
                        <th>Fue utilizado</th>
                        <th>Tipo de ticket</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tickets as $ticket)
                        <tr>
                            <td>{{ $ticket->user->name }}</td>
                            <td>{{ $ticket->event->name }}</td>
                            <td>{{ $ticket->purchase_date }}</td>
                            <td>{{ $ticket->confirmed ? 'Sí' : 'No' }}</td>
                            <td>{{ $ticket->ticketType->name }}</td>
                            <td>
                                <a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-warning">Editar</a>
                                <a href="{{ route('tickets.downloadQr', $ticket) }}" class="btn btn-info">Descargar QR</a>
                                @if(!$ticket->confirmed)
                                    <a href="{{ route('tickets.confirm', $ticket) }}" class="btn btn-success">Confirmar</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop