@extends('student.layouts.app')

@section('title', 'Student Dashboard')
@push('styles')
<style>
    .fc {
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        padding: 10px;
    }

    .fc-toolbar-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #333;
    }

    .fc-button {
        background-color: #f0f0f0 !important;
        border: none !important;
        color: #333 !important;
        transition: all 0.2s ease-in-out;
    }

    .fc-button:hover {
        background-color: #d6d6d6 !important;
    }

    .fc-daygrid-day-number {
        color: #333;
        font-weight: bold;
    }

    .fc-event {
        border: none !important;
        font-size: 0.8rem;
        padding: 2px 4px;
        border-radius: 5px;
        cursor: pointer;
    }

    .fc-event:hover {
        opacity: 0.9;
    }

    .fc-day-today {
        background-color: #f8f9fa !important;
    }
</style>
@endpush

@section('content')


    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $totalExams }}</h3>
                            <p>Sınavlar</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer">Daha fazla..<i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $completedExams }}</h3>
                            <p>Tamamlanmış Sınavlar</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer">Daha fazla..<i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $totalNotes }}</h3>
                            <p>Notlar</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer">Daha fazla..<i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $totalTasks }}</h3>
                            <p>Yapılacaklar</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="#" class="small-box-footer">Daha fazla..<i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->
            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <section class="col-lg-7 connectedSortable ui-sortable">
                    <!-- Custom tabs (Charts with tabs)-->
                    <div class="card">
                        <div class="card-header ui-sortable-handle" style="cursor: move;">
                            <h3 class="card-title">
                                <i class="fas fa-chart-pie mr-1"></i>
                                Sınav İlerlemesi
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="chart">
                                <canvas id="examProgressChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Study Tasks -->
                    <div class="card">
                        <div class="card-header ui-sortable-handle" style="cursor: move;">
                            <h3 class="card-title">
                                <i class="ion ion-clipboard mr-1"></i>
                                Çalışma Programı
                            </h3>
                        </div>
                        <div class="card-body">
                            <ul class="todo-list ui-sortable" data-widget="todo-list">
                                @foreach($tasks as $task)
                                <li class="{{ $task->is_completed ? 'done' : '' }}">
                                    <span class="handle ui-sortable-handle">
                                        <i class="fas fa-ellipsis-v"></i>
                                        <i class="fas fa-ellipsis-v"></i>
                                    </span>
                                    <div class="icheck-primary d-inline ml-2">
                                        <input type="checkbox" value="" name="todo{{ $task->id }}" id="todoCheck{{ $task->id }}" {{ $task->is_completed ? 'checked' : '' }}>
                                        <label for="todoCheck{{ $task->id }}"></label>
                                    </div>
                                    <span class="text">{{ $task->title }}</span>
                                    <small class="badge badge-info"><i class="far fa-clock"></i> {{ $task->duration }} mins</small>
                                    <small class="badge badge-secondary">{{ $task->subject }}</small>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </section>
                <!-- /.Left col -->
                <!-- right col -->
                <section class="col-lg-5 connectedSortable ui-sortable">
                    <!-- Calendar -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="far fa-calendar-alt"></i>
                                Calendar
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addEventModal">
                                    <i class="fas fa-plus"></i> Event ekle
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </section>
                <!-- right col -->
            </div>
            <!-- /.row (main row) -->
        </div>
    </section>

    <!-- Add Event Modal -->
    <div class="modal fade" id="addEventModal" tabindex="-1" role="dialog" aria-labelledby="addEventModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addEventModalLabel">Yeni event ekle</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addEventForm">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="eventTitle">Event Title</label>
                            <input type="text" class="form-control" id="eventTitle" required>
                        </div>
                        <div class="form-group">
                            <label for="eventStart">Start Date/Time</label>
                            <input type="datetime-local" class="form-control" id="eventStart" required>
                        </div>
                        <div class="form-group">
                            <label for="eventEnd">End Date/Time</label>
                            <input type="datetime-local" class="form-control" id="eventEnd">
                        </div>
                        <div class="form-group">
                            <label for="eventColor">Event Color</label>
                            <input type="color" class="form-control" id="eventColor" value="#3788d8">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Event</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const examLabels = @json($examAnalyses->pluck('exam.title'));
            const netValues = @json($examAnalyses->map(function ($analysis) {
        return round($analysis->correct_count - ($analysis->wrong_count / 4), 2);
    }));
        // Initialize Calendar
            document.addEventListener('DOMContentLoaded', function() {
                const calendarEl = document.getElementById('calendar');
                if (!calendarEl) {
                    console.error('Calendar element not found!');
                    return;
                }

                const calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    events: @json($calendarEvents),
                    eventClick: function(info) {
                        // Handle event click
                        alert('Event: ' + info.event.title);
                    },
                    eventDidMount: function(info) {
                        // Add tooltip
                        $(info.el).tooltip({
                            title: info.event.title,
                            placement: 'top',
                            trigger: 'hover',
                            container: 'body'
                        });
                    }
                });

                calendar.render();

                // Handle Add Event Form Submit
                $('#addEventForm').on('submit', function(e) {
                    e.preventDefault();

                    const eventData = {
                        title: $('#eventTitle').val(),
                        start: $('#eventStart').val(),
                        end: $('#eventEnd').val(),
                        backgroundColor: $('#eventColor').val(),
                        borderColor: $('#eventColor').val(),
                        textColor: '#ffffff'
                    };

                    // Send AJAX request to save event
                    $.ajax({
                        url: '/student/calendar/events',
                        method: 'POST',
                        data: eventData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            calendar.addEvent(eventData);
                            $('#addEventModal').modal('hide');
                            $('#addEventForm')[0].reset();
                        },
                        error: function(error) {
                            alert('Error saving event');
                        }
                    });
                });
            });

        // Initialize Exam Progress Chart
            const ctx = document.getElementById('examProgressChart').getContext('2d');
            new Chart(ctx, {
            type: 'bar',
            data: {
            labels: examLabels,
            datasets: [{
            label: 'Exam Progress',
            backgroundColor: 'rgba(60,141,188,0.9)',
            borderColor: 'rgba(60,141,188,0.8)',
            data: netValues
        }]
        },
            options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
            y: {
            beginAtZero: true,
            max: 10 // net en fazla kaç olabilir diye sınırlamak istersen
        }
        }
        }
        });
    </script>
    @endpush
@endsection
