@extends('layouts.app')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<div class="container mt-4">

    <h1>Calendario de Rodadas</h1>

    @if(request('fecha'))

        <a href="{{ url('/calendario') }}"
           class="btn btn-secondary mb-3">

            ← Volver al calendario

        </a>

    @endif

    <div id="calendar"></div>

</div>

{{-- MODAL --}}
<div class="modal fade" id="rodadaModal" tabindex="-1">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="modalTitle"></h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body">

                <div class="row">

                    {{-- TEXTO --}}
                    <div class="col-md-7">

                        <p>
                            <strong>🏁 Circuito:</strong>
                            <span id="modalCircuito"></span>
                        </p>

                        <p>
                            <strong>👤 Organizador:</strong>
                            <span id="modalOrganizador"></span>
                        </p>

                        <p>
                            <strong>💰 Precio:</strong>
                            <span id="modalPrecio"></span>
                        </p>

                        <p>
                            <strong>👥 Plazas:</strong>
                            <span id="modalPlazas"></span>
                        </p>

                    </div>

                    {{-- IMAGEN --}}
                    <div class="col-md-5 text-center">

                        <img id="modalImagen"
                             class="img-fluid rounded">

                    </div>

                </div>

            </div>

            <div class="modal-footer">

                <a id="modalLink"
                   class="btn btn-primary">

                    Ver detalles

                </a>

            </div>

        </div>

    </div>

</div>

<script>

document.addEventListener('DOMContentLoaded', function() {

    const params = new URLSearchParams(window.location.search);

    const fecha = params.get('fecha');

    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {

        locale: 'es',

        buttonText: {

            day: 'Día',
            month: 'Mes'

        },

        headerToolbar: {

            left: 'prev,next',

            center: 'title',

            right: 'dayGridMonth,dayGridDay'

        },

        initialView: fecha
            ? 'dayGridDay'
            : 'dayGridMonth',

        initialDate: fecha ? fecha : new Date(),

        noEventsContent: 'Hoy no hay rodadas',

        height: 'auto',

        events: 'rodadas-json',

        eventContent: function(arg) {

            return {
                html: `<b>${arg.event.title}</b>`
            };

        },

        eventDidMount: function(info) {

            let plazas = info.event.extendedProps.plazas;

            if (plazas <= 0) {

                info.el.style.backgroundColor = '#dc3545';

            }

            else if (plazas < 5) {

                info.el.style.backgroundColor = '#ffc107';
                info.el.style.color = 'black';

            }

            else {

                info.el.style.backgroundColor = '#28a745';

            }

            info.el.style.border = 'none';
            info.el.style.borderRadius = '8px';
            info.el.style.padding = '4px';
            info.el.style.fontSize = '12px';
            info.el.style.color = 'white';

        },

        eventClick: function(info) {

            // TÍTULO
            document.getElementById('modalTitle').innerHTML =

                '🏍️ ' + info.event.title;

            // DATOS
            document.getElementById('modalCircuito').innerText =

                info.event.extendedProps.circuito;

            document.getElementById('modalOrganizador').innerText =

                info.event.extendedProps.organizador;

            document.getElementById('modalPrecio').innerText =

                info.event.extendedProps.precio + ' €';

            document.getElementById('modalPlazas').innerText =

                info.event.extendedProps.plazas;

            // LINK
            document.getElementById('modalLink').href =

                window.location.origin +
                '/rodadas/' +
                info.event.id;

            // IMAGEN
            let imagen = info.event.extendedProps.imagen;

            if (imagen) {

                document.getElementById('modalImagen').src =

                    window.location.origin + '/' + imagen;

            }

            else {

                document.getElementById('modalImagen').src =

                    'https://via.placeholder.com/300x200?text=Sin+imagen';

            }

            // MODAL
            var modal = new bootstrap.Modal(

                document.getElementById('rodadaModal')

            );

            modal.show();

        }

    });

    calendar.render();

});

</script>

@endsection