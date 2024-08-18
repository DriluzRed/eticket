@extends('layouts.app')
@section('content_header')
    <h1>Tipos de Tickets</h1>
@stop
@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('ticket_types.create') }}" class="btn btn-primary">Crear Tipo de Ticket</a>
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
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ticket_types as $ticket_type)
                        <tr>
                            <td>{{ $ticket_type->name }}</td>
                            <td>{{ $ticket_type->description }}</td>
                            <td>{{ $ticket_type->price }}</td>
                            <td>
                                <a href="{{ route('ticket_types.edit', $ticket_type) }}" class="btn btn-warning">Editar</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop