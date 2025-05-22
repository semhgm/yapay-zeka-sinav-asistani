@extends('student.layouts.app')
@section('title', 'Çalışma Programı')

@section('content')
    <div class="card">
        <div class="card-header p-2">
            <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link active" href="#manuel" data-toggle="tab">Kendi Programımı Yapacağım</a></li>
                <li class="nav-item"><a class="nav-link" href="#ai" data-toggle="tab">Yapay Zeka ile Oluştur</a></li>
            </ul>
        </div>

        <div class="card-body">
            <div class="tab-content">
                <!-- MANUEL -->
                <div class="active tab-pane" id="manuel">
                    <form method="POST" action="{{ route('student.schedule.tasks.store') }}">
                        @csrf
                        <div class="form-group">
                            <label>Gün Seç</label>
                            <select class="form-control" name="day" required>
                                <option>Pazartesi</option>
                                <option>Salı</option>
                                <option>Çarşamba</option>
                                <option>Perşembe</option>
                                <option>Cuma</option>
                                <option>Cumartesi</option>
                                <option>Pazar</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Ders</label>
                            <input type="text" name="subject" class="form-control" placeholder="Örneğin: Matematik" required>
                        </div>
                        <div class="form-group">
                            <label>Görev Başlığı</label>
                            <input type="text" name="title" class="form-control" placeholder="Örneğin: Test 12 çöz" required>
                        </div>
                        <div class="form-group">
                            <label>Çalışma Süresi (dakika)</label>
                            <input type="number" name="duration" class="form-control" placeholder="Örneğin: 120" min="1" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Kaydet</button>
                    </form>
                </div>

                <!-- AI -->
                <div class="tab-pane" id="ai">
                    <form>
                        <div class="form-group">
                            <label>Hedef Fakülte</label>
                            <select class="form-control">
                                <option>Tıp Fakültesi</option>
                                <option>Hukuk Fakültesi</option>
                                <option>Mühendislik</option>
                                <option>Genel Başarı</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Günlük Çalışma Süresi (saat)</label>
                            <input type="number" class="form-control" placeholder="Örneğin: 5">
                        </div>
                        <div class="form-group">
                            <label>Hedef Puan</label>
                            <input type="text" class="form-control" placeholder="Örneğin: 480">
                        </div>
                        <div class="form-group">
                            <label>Mevcut Net Bilgileri</label>
                            <textarea class="form-control" rows="3" placeholder="Türkçe: 30, Matematik: 20, Fen: 15"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success" disabled>Yapay Zeka ile Program Oluştur (yakında)</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Günlük Görev Listesi -->
    @foreach($tasksByDay as $day => $tasks)
        <div class="card mt-3">
            <div class="card-header">
                <h3 class="card-title">{{ $day }}</h3>
            </div>
            <div class="card-body">
                @if(count($tasks) > 0)
                    <ul class="list-group">
                        @foreach($tasks as $task)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $task->title }}</strong> ({{ $task->duration }} dk)
                                    <br><span class="badge badge-primary">{{ $task->subject }}</span>
                                </div>
                                <div>
                                    <!-- Tamamla Butonu -->
                                    <form action="{{ route('student.schedule.tasks.toggle', $task->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-sm {{ $task->is_completed ? 'btn-success' : 'btn-outline-success' }}">
                                            {{ $task->is_completed ? 'Tamamlandı' : 'Tamamla' }}
                                        </button>
                                    </form>
                                    <!-- Sil Butonu -->
                                    <form action="{{ route('student.schedule.tasks.destroy', $task->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Sil</button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>Henüz görev yok.</p>
                @endif
            </div>
        </div>
    @endforeach
@stop
