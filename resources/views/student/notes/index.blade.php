@extends('student.layouts.app')

@section('content')
    <div class="container">
        <div class="card card-outline card-primary">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title"><i class="fas fa-sticky-note"></i> Notlarım</h3>
                <button class="btn btn-success" data-toggle="modal" data-target="#addNoteModal">
                    <i class="fas fa-plus"></i> Yeni Not Ekle
                </button>
            </div>

            <div class="card-body">
                <!-- Filtreleme Alanı -->
                <form method="GET" class="mb-3 row">
                    <div class="col-md-4">
                        <input type="text" name="tag" value="{{ request('tag') }}" class="form-control" placeholder="Etikete göre filtrele (örn: matematik)">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-outline-primary btn-block">
                            <i class="fas fa-filter"></i> Filtrele
                        </button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('student.notes.index') }}" class="btn btn-outline-secondary btn-block">
                            <i class="fas fa-times"></i> Temizle
                        </a>
                    </div>
                </form>

                <div class="row">
                    @forelse($notes as $note)
                        <div class="col-md-4">
                            <div class="card card-outline card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">{{ $note->title }}</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <form action="{{ route('student.notes.destroy', $note->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-tool" type="submit" onclick="return confirm('Silmek istediğine emin misin?')">
                                                <i class="fas fa-times text-danger"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if($note->tag)
                                        <span class="badge badge-secondary mb-2">{{ $note->tag }}</span>
                                    @endif

                                    <p>{!! nl2br(e($note->content)) !!}</p>

                                    @if($note->pdf_path)
                                        <a href="{{ asset('storage/' . $note->pdf_path) }}" target="_blank" class="btn btn-sm btn-outline-secondary mt-2">
                                            <i class="fas fa-file-pdf"></i> PDF Görüntüle
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <p class="text-muted">Henüz eklenmiş bir not yok.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addNoteModal" tabindex="-1" role="dialog" aria-labelledby="addNoteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('student.notes.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-plus"></i> Yeni Not Ekle</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="title">Başlık</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="content">İçerik</label>
                            <textarea class="form-control" name="content" rows="4"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="tag">Etiket (Konu)</label>
                            <input type="text" class="form-control" name="tag" placeholder="Örn: Paragraf, Fonksiyonlar">
                        </div>
                        <div class="form-group">
                            <label for="pdf">PDF Dosyası (isteğe bağlı)</label>
                            <input type="file" class="form-control-file" name="pdf" accept="application/pdf">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">İptal</button>
                        <button type="submit" class="btn btn-primary">Kaydet</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
