@extends('layouts.admin-master')

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/modules/datatables/DataTables-1.10.18/css/dataTables.bootstrap4.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/modules/datatables/Responsive-2.2.2/css/responsive.bootstrap4.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/modules/fullcalendar/fullcalendar.min.css')}}"/>
@endpush

@section('title')
Estoque
@endsection

@section('content')
    <section class="section">
      <div class="section-header">
        <h1>Calendar</h1>
      </div>
      <div class="section-body">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h4>Calendar</h4>
              </div>
              <div class="card-body">
                <div class="fc-overflow">                            
                  <div id="myEvent"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
@endsection

@push('scripts')
<script src="{{ asset('assets/modules/jquery-ui/jquery-ui.min.js')}}"></script>
<script src="{{ asset('assets/modules/fullcalendar/fullcalendar.min.js')}}"></script>
<script src="{{ asset('assets/js/page/modules-calendar.js')}}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('myEvent');
  var calendar = new FullCalendar.Calendar(calendarEl, {
    plugins: [ 'dayGrid', 'timeGrid' ],
    header: {
      left: 'prev,next today',
      center: 'title',
      right: 'dayGridMonth,timeGridWeek'
    },
    defaultDate: '2019-08-12',
    events: [
      {
        start: '2019-08-11T10:00:00',
        end: '2019-08-11T16:00:00',
        rendering: 'background',
        color: '#ff9f89'
      },
      {
        start: '2019-08-13T10:00:00',
        end: '2019-08-13T16:00:00',
        rendering: 'background',
        color: '#ff9f89'
      },
      {
        start: '2019-08-24',
        end: '2019-08-28',
        overlap: false,
        rendering: 'background'
      },
      {
        start: '2019-08-06',
        end: '2019-08-08',
        overlap: false,
        rendering: 'background'
      }
    ]
  });

  calendar.render();
});
</script>
@endpush
