@extends('layouts.app')
@section('content_header')
    <h1>Editar Ticket</h1>
@stop
@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('ticket_types.index') }}" class="btn btn-info">Volver </a>
        </div>
        <div class="card-body">
            <form action="{{ route('ticket_types.update', $ticket_type) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group
                    @if($errors->has('name'))
                        has-error
                    @endif">
                    <label for="name">Nombre</label>
                    <input type="text" class="form-control
                        @if($errors->has('name'))
                            is-invalid
                        @endif" name="name" id="name" value="{{ old('name', $ticket_type->name) }}">
                    @if($errors->has('name'))
                        <span class="help-block
                            @if($errors->has('name'))
                                is-invalid
                            @endif">
                            {{ $errors->first('name') }}
                        </span>
                    @endif
                </div>
                <div class="form-group
                    @if($errors->has('description'))
                        has-error
                    @endif">
                    <label for="description">Descripción</label>
                    <input type="text" class="form-control
                        @if($errors->has('description'))
                            is-invalid
                        @endif" name="description" id="description" value="{{ old('description', $ticket_type->description) }}">
                    @if($errors->has('description'))
                        <span class="help-block
                            @if($errors->has('description'))
                                is-invalid
                            @endif">
                            {{ $errors->first('description') }}
                        </span>
                    @endif
                </div>
                <div class="form-group
                    @if($errors->has('price'))
                        has-error
                    @endif">
                    <label for="price">Precio</label>
                    <input type="number" class="form-control
                        @if($errors->has('price'))
                            is-invalid
                        @endif" name="price" id="price" value="{{ old('price', $ticket_type->price) }}">
                    @if($errors->has('price'))
                        <span class="help-block
                            @if($errors->has('price'))
                                is-invalid
                            @endif">
                            {{ $errors->first('price') }}
                        </span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </form>
        </div>
    </div>
@stop