@extends('layouts.app')
@section('content_header')
    <h1>Emitir Tickets</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
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
            <a href="{{ route('tickets.index') }}" class="btn btn-primary">Volver</a>
        </div>
        <div class="card-body">
            <form id="ticket-form" method="POST" action="{{ route('tickets.store') }}">
                @csrf
            
                <div class="form-group
                    @error('event_id')
                        has-error
                    @enderror">
                    <label for="event_id">Evento:</label>
                    <select id="event_id" name="event_id" class="form-control" required>
                        <option value="">Seleccione un evento</option>
                        @foreach ($events as $event)
                            <option value="{{ $event->id }}" {{ old('event_id') == $event->id ? 'selected' : '' }}>{{ $event->name }}</option>
                        @endforeach
                    </select>
                    @error('event_id')
                        <span class="help-block">{{ $message }}</span>
                    @enderror
                </div>
            
                <div class="form-group
                    @error('ticket_type_id')
                        has-error
                    @enderror">
                    <label for="ticket_type_id">Tipo de Entrada:</label>
                    <select id="ticket_type_id" name="ticket_type_id" class="form-control" required>
                        <option value="">Seleccione un tipo de entrada</option>
                        @foreach ($ticketTypes as $ticketType)
                        <option value="{{ $ticketType->id }}" {{ old('ticket_type_id') == $ticketType->id ? 'selected' : '' }}>
                            {{ $ticketType->name }} - {{ number_format($ticketType->price, 0, ',', '.')  }} Gs.
                        </option>
                        @endforeach
                    </select>
                    @error('ticket_type_id')
                        <span class="help-block">{{ $message }}</span>
                    @enderror
                </div>
            
                <div class="form-group
                    @error('quantity')
                        has-error
                    @enderror">
                    <label for="quantity">Cantidad:</label>
                    <input type="number" id="quantity" name="quantity" class="form-control" min="1" max="10" required value="{{ old('quantity', 1) }}">
                    @error('quantity')
                        <span class="help-block">{{ $message }}</span>
                    @enderror
                </div>
            
                <h3>Tus Datos</h3>
                <div class="form-group
                    @error('ci')
                        has-error
                    @enderror">
                    <label for="ci">CI:</label>
                    <input type="text" id="ci" name="ci" class="form-control" required value="{{ old('ci') }}">
                    @error('ci')
                        <span class="help-block">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group
                @error('name')
                    has-error
                @enderror">
                <label for="name">Nombre:</label>
                <input type="text" id="name" name="name" class="form-control" required value="{{ old('name') }}">
                @error('name')
                    <span class="help-block">{{ $message }}</span>
                @enderror
            </div>
                <div class="form-group
                    @error('email')
                        has-error
                    @enderror">
                    <label for="email">Correo Electrónico:</label>
                    <input type="email" id="email" name="email" class="form-control" required value="{{ old('email') }}">
                    @error('email')
                        <span class="help-block">{{ $message }}</span>
                    @enderror
                </div>
               
                
            
                <div id="additional-tickets-container">
                    <h3>Entradas Adicionales</h3>
                    <!-- Los tickets adicionales se añadirán aquí dinámicamente -->
                </div>
            
                <button type="button" id="add-ticket-button" class="btn btn-primary">Agregar Entrada Adicional</button>
                <button type="submit" class="btn btn-success">Enviar</button>
            </form>
            
        </div>
        
    </div>
@stop
@section('js')

<script>
    $(document).ready(function () {
        let ticketCount = 0;
        $('#add-ticket-button').prop('disabled', true);

        $('#quantity').on('input', function () {
            const quantity = $(this).val();
            if (quantity > 1) {
                $('#add-ticket-button').prop('disabled', false);
            } else {
                $('#add-ticket-button').prop('disabled', true);
                $('#additional-tickets-container').empty();
            }
        });

        $('#add-ticket-button').click(function () {
            ticketCount++;
            $('#additional-tickets-container').append(`
                <div class="additional-ticket-form border p-2 mb-3">
                    <h4>Entrada Adicional ${ticketCount}</h4>
                    <div class="form-group">
                        <label for="additional_ticket_email_${ticketCount}">Correo Electrónico:</label>
                        <input type="email" id="additional_ticket_email_${ticketCount}" name="additional_tickets[${ticketCount}][email]" class="form-control form-control-sm" required>
                    </div>
                    <div class="form-group">
                        <label for="additional_ticket_name_${ticketCount}">Nombre:</label>
                        <input type="text" id="additional_ticket_name_${ticketCount}" name="additional_tickets[${ticketCount}][name]" class="form-control form-control-sm" required>
                    </div>
                    <div class="form-group">
                        <label for="additional_ticket_ci_${ticketCount}">CI:</label>
                        <input type="text" id="additional_ticket_ci_${ticketCount}" name="additional_tickets[${ticketCount}][ci]" class="form-control form-control-sm" required>
                    </div>
                </div>
            `);
        });
        $('#ci').on('input', function() {
        var ci = $(this).val();
        if (ci.length > 0) {
            $.ajax({
                url: '{{ route('search.by.ci') }}',
                method: 'GET',
                data: { ci: ci },
                success: function(data) {
                    if (data.name) {
                        $('#name').val(data.name);
                        $('#email').val(data.email);
                    } else {
                        $('#name').val('');
                        $('#email').val('');
                    }
                },
                error: function() {
                    $('#name').val('');
                    $('#email').val('');
                }
            });
        } else {
            $('#name').val('');
            $('#email').val('');
        }
    });
    });

   

</script>
</div>
@stop