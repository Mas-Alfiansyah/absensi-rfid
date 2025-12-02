@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Review & Ekspor Absensi</h3>
                </div>
                <div class="card-body">
                    <form id="exportForm">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label>Kelas</label>
                                <select name="kelas_id" class="form-control">
                                    <option value="">Semua Kelas</option>
                                    @foreach($kelas as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama_kelas }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Dari Tanggal</label>
                                <input type="date" name="start_date" class="form-control" value="{{ date('Y-m-01') }}">
                            </div>
                            <div class="col-md-3">
                                <label>Sampai Tanggal</label>
                                <input type="date" name="end_date" class="form-control" value="{{ date('Y-m-t') }}">
                            </div>
                            <div class="col-md-3">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-search"></i> Tampilkan
                                </button>
                            </div>
                        </div>
                    </form>
                    
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <button type="button" id="btnExportExcel" class="btn btn-success">
                                <i class="fas fa-file-excel"></i> Export Excel
                            </button>
                            <button type="button" id="btnExportPDF" class="btn btn-danger">
                                <i class="fas fa-file-pdf"></i> Export PDF
                            </button>
                        </div>
                    </div>
                    
                    <div id="exportData">
                        <!-- Data akan dimuat di sini -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#exportForm').on('submit', function(e) {
        e.preventDefault();
        loadExportData();
    });
    
    $('#btnExportExcel').on('click', function() {
        exportData('excel');
    });
    
    $('#btnExportPDF').on('click', function() {
        exportData('pdf');
    });
    
    function loadExportData() {
        $.ajax({
            url: '{{ route('export.getData') }}',
            type: 'POST',
            data: $('#exportForm').serialize(),
            success: function(response) {
                $('#exportData').html(response);
            }
        });
    }
    
    function exportData(type) {
        var form = $('#exportForm')[0];
        var formData = new FormData(form);
        
        if (type === 'excel') {
            formData.append('_method', 'POST');
            $.ajax({
                url: '{{ route('export.excel') }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(response) {
                    var blob = new Blob([response]);
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = 'absensi_export.xlsx';
                    link.click();
                }
            });
        } else {
            // Untuk PDF, gunakan form submission biasa
            form.action = '{{ route('export.pdf') }}';
            form.method = 'POST';
            form.submit();
        }
    }
});
</script>
@endpush