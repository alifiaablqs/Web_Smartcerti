@extends('layouts.template')

@section('title')| Pelatihan @endsection

@section('content')
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" data-width="75%" aria-hidden="true"></div>
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <button onclick="modalAction(`{{ url('/pelatihan/create') }}`)" class="btn btn-success" style="background-color: #EF5428; border-color: #EF5428;">Tambah</button>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <table class="table table-bordered table-striped table-hover table-sm" id="table_pelatihan">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Vendor</th>
                        <th>Jenis Pelatihan</th>
                        <th>Periode</th>          
                        <th>Nama Pelatihan</th>
                        <th>Level Pelatihan</th>
                        <th>Lokasi</th>
                        <th>Tanggal</th>
                        {{-- <th>Kuota Peserta</th> --}}
                        {{-- <th>Biaya</th> --}}
                        <th>Tag Bidang Minat</th>
                        <th>Tag Mata Kuliah</th>
                        @if (Auth::user()->id_level == 1)
                            <th>Nama Peserta</th>
                        @endif
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection
@push('css')
<style>
        .card.card-outline.card-primary {
            border-color: #375E97 !important;
        }
    </style>
@endpush
@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }
        var dataPelatihan;
        $(document).ready(function() {
    // Cek apakah user adalah admin (id_level = 1)
    var isAdmin = {{ Auth::user()->id_level == 1 ? 'true' : 'false' }};

    var columns = [
        {
            data: "DT_RowIndex",
            className: "text-center",
            width: "4%",
            orderable: false,
            searchable: false
        },
        {
            data: "vendor_pelatihan.nama",
            className: "",
            width: "9%",
            orderable: false,
            searchable: true
        },
        {
            data: "jenis_pelatihan.nama_jenis_pelatihan",
            className: "",
            width: "9%",
            orderable: false,
            searchable: true,
        },
        {
            data: "periode.tahun_periode",
            className: "",
            width: "6%",
            orderable: false,
            searchable: false
        },
        {
            data: "nama_pelatihan",
            className: "",
            width: "9%",
            orderable: true,
            searchable: true
        },
        {
            data: "level_pelatihan",
            className: "",
            width: "6%",
            orderable: false,
            searchable: true
        },
        {
            data: "lokasi",
            className: "",
            width: "6%",
            orderable: false,
            searchable: true
        },
        {
            data: "tanggal",
            className: "",
            width: "8%",
            orderable: false,
            searchable: false
        },
        {
            data: "bidang_minat",
            render: function(data, type, row) {
                return row.bidang_minat ? row.bidang_minat : '-';
            },
            className: "",
            width: "10%",
            orderable: false,
            searchable: false
        },
        {
            data: "mata_kuliah",
            render: function(data, type, row) {
                return row.mata_kuliah ? row.mata_kuliah : '-';
            },
            className: "",
            width: "10%",
            orderable: false,
            searchable: false
        },
        {
            data: "aksi",
            className: "",
            width: "9%",
            orderable: false,
            searchable: false
        }
    ];

    // Tambahkan kolom "Nama Peserta" jika user adalah admin
    if (isAdmin) {
        columns.splice(10, 0, {
            data: "peserta_pelatihan",
            render: function(data, type, row) {
                return row.peserta_pelatihan ? row.peserta_pelatihan : '-';
            },
            className: "",
            width: "10%",
            orderable: false,
            searchable: false
        });
    }

    dataPelatihan = $('#table_pelatihan').DataTable({
        serverSide: true,
        ajax: {
            url: "{{ url('pelatihan/list') }}",
            dataType: "json",
            type: "POST",
        },
        columns: columns
    });
        });
    </script>
@endpush