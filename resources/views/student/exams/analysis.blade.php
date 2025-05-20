@extends('student.layouts.app')
@section('title', 'Sınav Analizleri')

{{-- Place custom styles within @push('styles') --}}
@push('styles')
    <style>
        /* Ensure vertical alignment in modal tables */
        #analysisModal .modal-body table td,
        #analysisModal .modal-body table th {
            vertical-align: middle !important;
        }
        /* Style for badges inside table cells */
        #analysisModal .modal-body table td .badge {
            margin-right: 5px; /* Add some space between topic badges */
            margin-bottom: 3px; /* Add space for wrapping badges */
            display: inline-block; /* Ensure margin works correctly */
        }
        /* Style for the loading indicator */
        .loading-analysis {
            min-height: 150px; /* Give some space for the spinner/text */
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            gap: 15px; /* Space between spinner and text */
        }
        .loading-analysis .spinner-border {
            width: 3rem;
            height: 3rem;
        }
        /* Optional: Adjust chart container height if needed */
        #resultChartContainer {
            min-height: 250px; /* Ensure chart has enough space */
            display: flex; /* Use flex to center chart vertically */
            justify-content: center;
            align-items: center;
        }
        #resultChart {
            max-height: 300px; /* Limit max height if needed */
        }

        /* Make modal title look better */
        #analysisModal .modal-header {
            border-bottom: none; /* Remove standard border if desired */
        }

    </style>
@endpush

@section('content')
    <div class="container-fluid mt-3">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0"><i class="fas fa-chart-bar"></i> Sınav Analizleri</h3>
            </div>
            <div class="card-body">
                <table id="examTable" class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Sınav Adı</th>
                        <th>İşlem</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($exams as $exam)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $exam->name }}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary show-analysis" data-exam-id="{{ $exam->id }}" data-exam-name="{{ $exam->name }}">
                                    <i class="fas fa-eye"></i> Detay
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="analysisModal" tabindex="-1" aria-labelledby="analysisModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable"> {{-- modal-dialog-scrollable makes modal body scrollable --}}
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="analysisModalLabel"><i class="fas fa-chart-line"></i> Sınav Analizi</h5>
                    {{-- Close Button --}}
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Kapat">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">
                    {{-- Initial loading state --}}
                    <div id="analysisLoading" class="loading-analysis">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Yükleniyor...</span>
                        </div>
                        <p>Analiz verileri yükleniyor...</p>
                    </div>

                    {{-- Content area (will be filled by JS) --}}
                    <div id="analysisContentArea" style="display: none;">
                        {{-- Exam name can be placed here or in title --}}
                        <h4 id="modalExamName" class="mb-3"></h4>

                        {{-- Analysis Summary --}}
                        <div id="analysisSummary" class="alert alert-primary text-center mb-4" style="display: none;">
                            {{-- Summary details will be loaded here --}}
                        </div>

                        {{-- Chart and Table Row --}}
                        <div class="row">
                            <div class="col-md-4">
                                <h6 class="text-center mb-3"><i class="fas fa-chart-pie"></i> Genel Sonuç Dağılımı</h6>
                                <div id="resultChartContainer">
                                    <canvas id="resultChart"></canvas>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h6 class="text-center mb-3"><i class="fas fa-list-alt"></i> Detaylı Cevap Analizi</h6>
                                <div id="analysisTableArea">
                                    {{-- Table will be loaded here --}}
                                </div>
                            </div>
                        </div>

                        {{-- AI Comment Area --}}
                        <div id="aiCommentArea" class="mt-4" style="display: none;">
                            <div class="card shadow border-left-primary">
                                <div class="card-body">
                                    <h5 class="card-title text-primary">
                                        <i class="fas fa-robot"></i> Yapay Zeka Yorumu
                                    </h5><br>
                                    <hr>
                                    <div id="aiCommentText" class="card-text text-dark" style="line-height: 1.6;"></div>
                                </div>
                            </div>
                        </div>
                        {{-- END AI Comment Area --}}

                    </div>

                    {{-- Error message area --}}
                    <div id="analysisError" class="alert alert-danger mt-3" style="display: none;">
                        {{-- Error message will be loaded here --}}
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary swalDefaultInfo" id="analyzeWithAI">
                        <i class="fas fa-robot"></i>Yapay Zeka ile Yorumla
                    </button>
                    {{-- Close Button in footer --}}
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- Make sure you have Chart.js included *before* this script --}}
    {{-- Example: <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
    {{-- And likely a library for spinners if you use those --}}

    <script>
        $(function () {
            // Initialize DataTable
            $('#examTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json'
                }
            });

            // Variable to hold the chart instance
            let analysisChart = null;
            // Define the modal variable within the scope
            const modal = $('#analysisModal');

            // Handle click on 'Detay' button
            $(document).on('click', '.show-analysis', function () {
                const examId = $(this).data('exam-id');
                const examName = $(this).data('exam-name');

                // Reset modal content state
                $('#analysisContentArea').hide();
                $('#analysisLoading').show(); // Show loading spinner
                $('#analysisError').hide().html(''); // Hide previous errors
                $('#analysisSummary').hide().html('');
                $('#analysisTableArea').html(''); // Clear table area
                $('#modalExamName').text(''); // Clear exam name
                $('#aiCommentArea').hide(); // Hide AI area on new load
                $('#aiCommentText').html(''); // Clear AI text on new load


                // Destroy previous chart instance if it exists
                if (analysisChart) {
                    analysisChart.destroy();
                    analysisChart = null;
                }

                // Set modal title dynamically
                modal.find('.modal-title').html(`<i class="fas fa-chart-line"></i> Sınav Analizi - ${examName}`);
                $('#modalExamName').text(examName); // Also show name in body

                // Show the modal
                modal.modal('show');

                // Fetch analysis data
                $.get(`/student/analyses/${examId}`, function (data) {
                    $('#analysisLoading').hide(); // Hide loading spinner on success
                    $('#analysisContentArea').show(); // Show content area

                    const correct = data.correct;
                    const wrong = data.wrong;
                    const totalQuestions = data.answers.length;
                    const empty = totalQuestions - (correct + wrong);
                    const net = data.net;

                    // 📊 Chart Oluşturma
                    // Use Bootstrap's 'shown.bs.modal' event for more reliable rendering
                    modal.one('shown.bs.modal', function () {
                        const ctx = document.getElementById('resultChart');
                        if (ctx) {
                            const chartContext = ctx.getContext('2d');
                            if (analysisChart) { // Check again before creating a new one
                                analysisChart.destroy();
                                analysisChart = null;
                            }

                            analysisChart = new Chart(chartContext, {
                                type: 'doughnut',
                                data: {
                                    labels: ['Doğru', 'Yanlış', 'Boş'],
                                    datasets: [{
                                        data: [correct, wrong, empty],
                                        backgroundColor: [
                                            '#28a745', // Bootstrap success green
                                            '#dc3545', // Bootstrap danger red
                                            '#6c757d'  // Bootstrap secondary gray
                                        ],
                                        borderColor: '#fff',
                                        borderWidth: 2
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: {
                                        legend: {
                                            position: 'bottom',
                                            labels: {
                                                boxWidth: 15,
                                                padding: 15
                                            }
                                        },
                                        tooltip: {
                                            callbacks: {
                                                label: function (context) {
                                                    const label = context.label || '';
                                                    if (label) {
                                                        let value = context.raw;
                                                        let percentage = totalQuestions > 0 ? ((value / totalQuestions) * 100).toFixed(1) : 0;
                                                        return `${label}: ${value} (${percentage}%)`;
                                                    }
                                                    return '';
                                                }
                                            }
                                        }
                                    }
                                }
                            });
                        } else {
                            console.error("Chart canvas element not found when modal was shown!");
                        }
                    });

                    // 📋 Summary Oluşturma
                    const summaryHtml = `
                        <strong>Toplam Soru:</strong> ${totalQuestions} |
                        <strong>Doğru:</strong> ${correct} |
                        <strong>Yanlış:</strong> ${wrong} |
                        <strong>Boş:</strong> ${empty} |
                        <strong>Net:</strong> ${net !== undefined && net !== null ? net.toFixed(2) : 'N/A'}
                     `;
                    $('#analysisSummary').html(summaryHtml).show();

                    // 📋 Tablo Oluşturma
                    let tableHtml = `<table class="table table-sm table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Soru</th>
                                <th style="width: 25%;">Konu(lar)</th>
                                <th>Cevabın</th>
                                <th>Doğru Cevap</th>
                                <th>Durum</th>
                            </tr>
                        </thead>
                        <tbody>`;

                    if (data.answers && data.answers.length > 0) {
                        data.answers.forEach(ans => {
                            const questionText = ans.question && ans.question.question_text
                                ? ans.question.question_text.substring(0, 80) + (ans.question.question_text.length > 80 ? '...' : '')
                                : 'N/A';
                            const topics = ans.question && ans.question.topics && ans.question.topics.length > 0
                                ? ans.question.topics.map(t => `<span class="badge badge-primary">${t.name}</span>`).join(' ')
                                : 'Konu bilgisi yok';

                            const statusBadge = ans.is_correct
                                ? '<span class="badge badge-success"><i class="fas fa-check"></i> Doğru</span>'
                                : '<span class="badge badge-danger"><i class="fas fa-times"></i> Yanlış</span>';

                            tableHtml += `<tr>
                                 <td>${questionText}</td>
                                 <td>${topics}</td>
                                 <td>${ans.given_answer ?? '-'}</td>
                                 <td>${ans.question ? ans.question.correct_answer : 'N/A'}</td>
                                 <td>${statusBadge}</td>
                             </tr>`;
                        });
                    } else {
                        tableHtml += `<tr><td colspan="5" class="text-center">Bu sınava ait detaylı cevap verisi bulunamadı.</td></tr>`;
                    }


                    tableHtml += `</tbody></table>`;

                    $('#analysisTableArea').html(tableHtml);

                }).fail(function (jqXHR, textStatus, errorThrown) {
                    // Handle AJAX error
                    $('#analysisLoading').hide(); // Hide loading
                    $('#analysisContentArea').hide(); // Hide content area
                    $('#analysisError').html('<i class="fas fa-exclamation-circle"></i> Analiz yüklenirken bir hata oluştu. Lütfen daha sonra tekrar deneyin. Hata: ' + (jqXHR.responseJSON ? jqXHR.responseJSON.message : textStatus)).show();
                    console.error("Analysis fetch error:", textStatus, errorThrown, jqXHR);
                });
            });

            // Handle AI button click
            $(document).on('click', '#analyzeWithAI', function () {
                Swal.fire({
                    icon: 'info',
                    title: 'Yapay Zeka Analizi',
                    text: 'Analiz başlatılıyor...',
                    timer: 2000,
                    showConfirmButton: false
                });
                // Ensure analysis data and chart are available
                if (!analysisChart || !analysisChart.data || !analysisChart.data.datasets || analysisChart.data.datasets.length === 0) {
                    // Make sure AI comment area is visible to show the message
                    $('#aiCommentArea').show();
                    $('#aiCommentText').html(`<span class="text-warning">Analiz verileri henüz yüklenmedi veya grafik oluşturulamadı. Lütfen bekleyin.</span>`);
                    return;
                }

                // Show the AI comment area and loading text
                $('#aiCommentArea').show();
                $('#aiCommentText').html(`<i class="fas fa-spinner fa-spin text-primary"></i> Yapay zeka analizi hazırlanıyor...`);


                // AJAX sonrası başarılı dönüşte:
                success: function goAnalysis(res) {
                    $('#aiCommentText').html(res.comment.replace(/\n/g, "<br>"));

                    // Sayfayı yorum alanına kaydır
                    $('html, body').animate({
                        scrollTop: $('#aiCommentArea').offset().top - 100
                    }, 800);

                    // Highlight efekti ver (arka plan parlatma)
                    $('#aiCommentArea')
                        .css({ backgroundColor: '#fff9c4' }) // sarımsı parlaklık
                        .animate({ backgroundColor: '#ffffff' }, 1500);
                }

                // Access chart data using the correct variable
                const chartData = analysisChart.data.datasets[0].data;
                const correct = chartData[0];
                const wrong = chartData[1];
                const empty = chartData[2];
                // Calculate net (assuming 4 wrong answers = 1 net loss)
                const net = (correct - wrong / 4);

                // Get topic names from the table
                const topics = [];
                $('#analysisTableArea table tbody tr').each(function () {
                    $(this).find('td:nth-child(2) .badge').each(function () {
                        const topic = $(this).text().trim();
                        if (topic !== 'Konu bilgisi yok' && topic !== '' && !topics.includes(topic)) {
                            topics.push(topic);
                        }
                    });
                });

                $.ajax({
                    url: '/student/ai-analysis',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: 'application/json',
                    data: JSON.stringify({
                        correct: correct,
                        wrong: wrong,
                        empty: empty,
                        net: net,
                        topics: topics
                    }),
                    success: function (res) {
                        if (res.comment) {
                            $('#aiCommentText').html(res.comment.replace(/\n/g, "<br>"));
                        } else {
                            $('#aiCommentText').html(`<span class="text-warning">Yorum alınamadı.</span>`);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        $('#aiCommentText').html(`<span class="text-danger">Yapay zeka analizi alınamadı. Hata: ${jqXHR.responseJSON ? jqXHR.responseJSON.message : errorThrown}</span>`);
                        console.error("AI analysis fetch error:", textStatus, errorThrown, jqXHR);
                    }
                });
                // Clear chart and content state when modal is closed
                // This handler is correctly placed inside the $(function() { ... }) scope
                modal.on('hidden.bs.modal', function () {
                    // Destroy the chart instance
                    if (analysisChart) {
                        analysisChart.destroy();
                        analysisChart = null;
                    }
                    // Reset content visibility
                    $('#analysisContentArea').hide();
                    $('#analysisLoading').show(); // Show loading again for next open
                    $('#analysisError').hide().html('');
                    // Hide/clear AI comment area
                    $('#aiCommentArea').hide();
                    $('#aiCommentText').html('');
                    // Clear dynamic content
                    $('#analysisSummary').hide().html('');
                    $('#analysisTableArea').html('');
                    $('#modalExamName').text('');
                    // Reset modal title
                    modal.find('.modal-title').html(`<i class="fas fa-chart-line"></i> Sınav Analizi`);
                });

            });
        });

    </script>
@endpush
