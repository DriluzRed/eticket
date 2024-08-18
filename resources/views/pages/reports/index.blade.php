@extends('layouts.app')

@section('content_header')
    <h1>Reportes</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('home') }}" class="btn btn-info">Volver</a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="event_id">Seleccione el evento</label>
                        <select name="event_id" id="event_id" class="form-control">
                            <option value="">Seleccione un evento</option>
                            @foreach($events as $event)
                                <option value="{{ $event->id }}">{{ $event->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Contenedor para la tabla -->
            <div class="row">
                <div class="col-md-12">
                    <h3>Detalles del Evento</h3>
                    <table class="table table-bordered" id="event-details-table" style="display: none;">
                        <thead>
                            <tr>
                                <th>Nombre del Evento</th>
                                <th>Total Entradas Vendidas</th>
                                <th>Entradas Confirmadas</th>
                                <th>Ingresos Totales</th>
                                <th>Entradas por Tipo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td id="event-name"></td>
                                <td id="total-tickets"></td>
                                <td id="total-used-tickets"></td>
                                <td id="total-revenue"></td>
                                <td id="total-tickets-per-type"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
    <script>
        $(document).ready(function() {
            $('#event_id').on('change', function() {
                var eventId = $(this).val();
                if (eventId) {
                    $.ajax({
                        url: '{{ route("reports.generateByEvent") }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            event_id: eventId
                        },
                        success: function(response) {
                            // Mostrar la tabla
                            $('#event-details-table').show();

                            // Llenar los datos en la tabla
                            $('#event-name').text(response.event.name);
                            $('#total-tickets').text(response.totalTickets);
                            $('#total-used-tickets').text(response.totalUsedTickets);
                            $('#total-revenue').text(response.totalRevenue);

                            // Construir la lista de entradas por tipo
                            var ticketsPerType = '';
                            $.each(response.totalTicketsPerType, function(type, count) {
                                ticketsPerType += type + ': ' + count + '<br>';
                            });
                            $('#total-tickets-per-type').html(ticketsPerType);
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                        }
                    });
                } else {
                    // Ocultar la tabla si no hay un evento seleccionado
                    $('#event-details-table').hide();
                }
            });
        });
    </script>
@stop
                
                
                                                            