@extends('student.layouts.app')
<!-- exam.store route'u JS'e taşımak için -->
@section('title', 'Takvim')

@push('styles')
    <!-- FullCalendar CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css">
    <!-- jQuery UI CSS -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <style>
        #external-events {
            padding: 10px;
            margin-bottom: 10px;
        }
        .external-event {
            padding: 8px;
            margin-bottom: 5px;
            cursor: pointer;
            border-radius: 3px;
        }
        #calendar {
            max-width: 100%;
            margin: 0 auto;
        }
    </style>
@endpush

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="sticky-top mb-3">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Event Templates</h4>
                                <small class="text-muted">Drag these to the calendar or create your own</small>
                            </div>
                            <div class="card-body">
                                <!-- the events -->
                                <div id="external-events"><div class="external-event ui-draggable ui-draggable-handle" style="background-color: rgb(167, 29, 42); border-color: rgb(167, 29, 42); color: rgb(255, 255, 255); position: relative; z-index: auto; left: 0px; top: 0px;">matematik çöz</div>
                                    <div class="external-event bg-success ui-draggable ui-draggable-handle" style="position: relative;">Lunch</div>
                                    <div class="external-event bg-warning ui-draggable ui-draggable-handle" style="position: relative;">Go home</div>
                                    <div class="external-event bg-info ui-draggable ui-draggable-handle" style="position: relative;">Do homework</div>
                                    <div class="external-event bg-primary ui-draggable ui-draggable-handle" style="position: relative;">Work on UI design</div>
                                    <div class="external-event bg-danger ui-draggable ui-draggable-handle" style="position: relative;">Sleep tight</div>
                                    <div class="checkbox">
                                        <label for="drop-remove">
                                            <input type="checkbox" id="drop-remove">
                                            remove after drop
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Create Event</h3>
                            </div>
                            <div class="card-body">
                                <div class="btn-group" style="width: 100%; margin-bottom: 10px;">
                                    <ul class="fc-color-picker" id="color-chooser">
                                        <li><a class="text-primary" href="#"><i class="fas fa-square"></i></a></li>
                                        <li><a class="text-warning" href="#"><i class="fas fa-square"></i></a></li>
                                        <li><a class="text-success" href="#"><i class="fas fa-square"></i></a></li>
                                        <li><a class="text-danger" href="#"><i class="fas fa-square"></i></a></li>
                                        <li><a class="text-muted" href="#"><i class="fas fa-square"></i></a></li>
                                    </ul>
                                </div>
                                <!-- /btn-group -->
                                <div class="input-group">
                                    <input id="new-event" type="text" class="form-control" placeholder="Event Title">

                                    <div class="input-group-append">
                                        <button id="add-new-event" type="button" class="btn btn-primary" style="background-color: rgb(167, 29, 42); border-color: rgb(167, 29, 42);">Add</button>
                                    </div>
                                    <!-- /btn-group -->
                                </div>
                                <!-- /input-group -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Calendar</h3>
                            <div class="card-tools">
                                <button id="remove-all-events" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Remove All Events
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <!-- THE CALENDAR -->
                            <div id="calendar"></div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
@endsection

@push('scripts')
    <!-- jQuery UI -->
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <!-- FullCalendar JS and Plugins -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/locales-all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@5.10.1/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@5.10.1/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@5.10.1/main.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            /* initialize the external events
            -----------------------------------------------------------------*/
            var containerEl = document.getElementById('external-events');
            new FullCalendar.Draggable(containerEl, {
                itemSelector: '.external-event',
                eventData: function(eventEl) {
                    return {
                        title: eventEl.innerText,
                        backgroundColor: window.getComputedStyle(eventEl, null).getPropertyValue('background-color'),
                        borderColor: window.getComputedStyle(eventEl, null).getPropertyValue('background-color'),
                        textColor: window.getComputedStyle(eventEl, null).getPropertyValue('color')
                    };
                }
            });

            /* initialize the calendar
            -----------------------------------------------------------------*/
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                themeSystem: 'bootstrap',
                initialView: 'dayGridMonth',
                height: 'auto',
                navLinks: true, // can click day/week names to navigate views
                editable: true,
                selectable: true,
                nowIndicator: true,
                dayMaxEvents: true, // allow "more" link when too many events
                droppable: true, // this allows things to be dropped onto the calendar
                eventClick: function(info) {
                    if (confirm('Are you sure you want to delete this event?')) {
                        $.ajax({
                            url: '/student/calendar/destroy/' + info.event.id,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    info.event.remove();
                                    alert('Event deleted successfully');
                                } else {
                                    alert('Failed to delete event');
                                }
                            },
                            error: function() {
                                alert('An error occurred while deleting the event');
                            }
                        });
                    }
                },
                drop: function(info) {
                    var eventObj = info.draggedEl.innerText;
                    var bg = info.draggedEl.style.backgroundColor;
                    var text = info.draggedEl.style.color;

                    // Yeni event bilgilerini gönder
                    $.post('/student/calendar/store', {
                        _token: '{{ csrf_token() }}',
                        title: eventObj,
                        start: info.dateStr,
                        backgroundColor: bg,
                        borderColor: bg,
                        textColor: text
                    }, function(response) {
                        if (document.getElementById('drop-remove').checked) {
                            info.draggedEl.remove();
                        }
                    });
                },
                events: '/student/calendar/events', // dinamik endpoint
            });
            calendar.render();

            /* ADDING NEW EVENT */
            var currColor = '#3c8dbc'; //Red by default
            // Color chooser button
            $('#color-chooser > li > a').click(function (e) {
                e.preventDefault();
                // Save color
                currColor = $(this).css('color');
                // Add color effect to button
                $('#add-new-event').css({
                    'background-color': currColor,
                    'border-color': currColor
                });
            });
            $('#add-new-event').click(function (e) {
                e.preventDefault();
                // Get value and make sure it is not null
                var val = $('#new-event').val();
                if (val.length == 0) {
                    return;
                }

                // Create event
                var event = $('<div />');
                event.css({
                    'background-color': currColor,
                    'border-color': currColor,
                    'color': '#fff'
                }).addClass('external-event');
                event.text(val);
                $('#external-events').prepend(event);

                // Add draggable functionality
                new FullCalendar.Draggable(event[0], {
                    eventData: function() {
                        return {
                            title: event.text(),
                            backgroundColor: currColor,
                            borderColor: currColor,
                            textColor: '#fff'
                        };
                    }
                });

                // Clear input
                $('#new-event').val('');
            });

            // Handle Remove All Events button click
            $('#remove-all-events').click(function(e) {
                e.preventDefault();
                if (confirm('Are you sure you want to remove all events? This action cannot be undone.')) {
                    $.ajax({
                        url: '/student/calendar/destroy-all',
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                // Refresh the calendar
                                calendar.refetchEvents();
                                alert('All events have been removed successfully');
                            } else {
                                alert('Failed to remove events');
                            }
                        },
                        error: function() {
                            alert('An error occurred while removing events');
                        }
                    });
                }
            });
        });
    </script>
@endpush
