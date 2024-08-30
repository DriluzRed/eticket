@extends('layouts.app')
@section('content_header')
    <h1>Editar Usuarios</h1>
@stop
@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('users.index') }}" class="btn btn-info">Volver </a>
        </div>
        <div class="card-body">
            <form action="{{ route('users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group
                    @if($errors->has('ci'))
                        has-error
                    @endif">
                    <label for="ci">Cedula</label>
                    <input type="text" class="form-control
                        @if($errors->has('ci'))
                            is-invalid
                        @endif" name="ci" id="ci" value="{{ old('ci', $user->ci) }}">
                    @if($errors->has('ci'))
                        <span class="help-block
                            @if($errors->has('ci'))
                                is-invalid
                            @endif">
                            {{ $errors->first('ci') }}
                        </span> 
                    @endif
                </div>
                <div class="form-group
                    @if($errors->has('name'))
                        has-error
                    @endif">
                    <label for="name">Nombre</label>
                    <input type="text" class="form-control
                        @if($errors->has('name'))
                            is-invalid
                        @endif" name="name" id="name" value="{{ old('name', $user->name) }}">
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
                    @if($errors->has('email'))
                        has-error
                    @endif">
                    <label for="email">Correo</label>
                    <input type="email" class="form-control
                        @if($errors->has('email'))
                            is-invalid
                        @endif" name="email" id="email" value="{{ old('email', $user->email) }}">
                    @if($errors->has('email'))
                        <span class="help-block
                            @if($errors->has('email'))
                                is-invalid
                            @endif">
                            {{ $errors->first('email') }}
                        </span>
                    @endif
                </div>
                <button type="submit" class="btn btn-success">Actualizar Datos</button>
            </form>
        </div>
    </div>
@stop
