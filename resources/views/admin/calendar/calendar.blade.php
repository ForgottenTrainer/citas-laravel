@extends('layouts.admin')
@section('content')
    <h3 class="page-title">{{ trans('global.systemCalendar') }}</h3>
    <div class="card">
        <div class="card-header">
            {{ trans('global.systemCalendar') }}
        </div>

        <div class="card-body">
            <link rel='stylesheet'
                  href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css'/>
            <div class="form-group">
                <label for="doctorFilter">Filtrar por psicologo:</label>
                <input type="text" class="form-control" id="doctorFilter" placeholder="Ingrese el nombre del psicologo">
            </div>


            <div id='calendar'></div>


        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script>
    <script>
      $(document).ready(function () {
        // page is now ready, initialize the calendar...
        events ={!! json_encode($events) !!};
        $('#calendar').fullCalendar({
          // put your options and callbacks here
          events: events,
          defaultView: 'agendaWeek'
        })
      })
    </script>
    <script>
    var events = {!! json_encode($events) !!};

      // Crear una copia de los eventos originales para restaurarlos después de la filtración
      var originalEvents = events.slice();

      // Inicializar FullCalendar con los eventos originales
      var calendar = $('#calendar').fullCalendar({
        events: events,
        defaultView: 'agendaWeek'
      });

      // Función para filtrar los eventos por nombre del doctor
      function filterEventsByDoctor(doctorName) {
        if (doctorName.trim() === '') {
          // Si el input está vacío, restaurar los eventos originales
          calendar.fullCalendar('removeEvents');
          calendar.fullCalendar('addEventSource', originalEvents);
        } else {
          // Filtrar los eventos por nombre del doctor
          var filteredEvents = originalEvents.filter(function (event) {
            return event.title.toLowerCase().includes(doctorName.toLowerCase());
          });
          // Mostrar solo los eventos filtrados
          calendar.fullCalendar('removeEvents');
          calendar.fullCalendar('addEventSource', filteredEvents);
        }
      }

      // Escuchar el evento 'input' en el input para filtrar los eventos en tiempo real
      $('#doctorFilter').on('input', function () {
        var doctorName = $(this).val();
        filterEventsByDoctor(doctorName);
      });
    </script>
@stop