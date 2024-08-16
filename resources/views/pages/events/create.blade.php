@extends('layouts.app')
@section('content_header')
    <h1>Crear Evento</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('events.index') }}" class="btn btn-info">Volver </a>
        </div>
        <div class="card-body">
            <form action="{{ route('events.store') }}" method="POST">
                @csrf
                <div class="form-group
                @error('name')
                    has-error
                @enderror">
                    <label for="name">Nombre</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                    @error('name')
                        <span class="help-block
                        @error('name')
                            has-error
                        @enderror">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group
                @error('description')
                    has-error
                @enderror">
                    <label for="description">Descripción</label>
                    <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="help-block
                        @error('description')
                            has-error
                        @enderror">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group
                @error('city_id')
                    has-error
                @enderror">
                    <label for="city_id">Ciudad</label>
                    <select name="city_id" id="city_id" class="form-control">
                        <option value="">Seleccione una ciudad</option>
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                        @endforeach
                    </select>
                    @error('city_id')
                        <span class="help-block
                        @error('city_id')
                            has-error
                        @enderror">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group
                @error('address')
                    has-error
                @enderror">
                    <label for="address">Dirección</label>
                    <input type="text" name="address" id="address" class="form-control" value="{{ old('address') }}">
                    @error('address')
                        <span class="help-block
                        @error('address')
                            has-error
                        @enderror">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group
                @error('event_date')
                    has-error
                @enderror">
                    <label for="event_date">Fecha</label>
                    <input type="date" name="event_date" id="event_date" class="form-control" value="{{ old('event_date') }}">
                    @error('event_date')
                        <span class="help-block
                        @error('event_date')
                            has-error
                        @enderror">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </form>
        </div>
    </div>
@stop
@section('js')

@stop
