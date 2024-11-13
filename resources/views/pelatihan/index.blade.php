@extends('layouts.template')

@section('title')| pelatihan @endsection

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
                        <th>Periode</th>
                        <th>Jenis Pelatihan</th>
                        <th>Nama Pelatihan</th>
                        <th>Level Pelatihan</th>
                        <th>Lokasi</th>
                        <th>Tanggal</th>
                        <th>Bukti Pelatihan</th>
                        <th>Kuota Peserta</th>
                        <th>Biaya</th>
                        {{-- <th>Tag Bidang Minat</th>
                        <th>Tag Mata Kuliah</th> --}}
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
            datapelatihan = $('#table_pelatihan').DataTable({
                // serverSide: true, jika ingin menggunakan server side processing
                serverSide: true,
                ajax: {
                    "url": "{{ url('pelatihan/list') }}",
                    "dataType": "json",
                    "type": "POST",
                },
                columns: [{
                    data: "DT_RowIndex",
                    className: "text-center",
                    width: "5%",
                    orderable: false,
                    searchable: false
                }, {
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
                    data: "lokasi",
                    className: "",
                    width: "8%",
                    orderable: false,
                    searchable: true
                },
                {
                    data: "level_pelatihan",
                    className: "",
                    width: "7%",
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
                    data: "bukti_pelatihan",
                    className: "",
                    width: "8%",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "masa_berlaku",
                    className: "",
                    width: "7%",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "kuota_peserta",
                    className: "",
                    width: "6%",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "biaya",
                    className: "",
                    width: "6%",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "aksi",
                    className: "",
                    width: "12%",
                    orderable: false,
                    searchable: false
                }]
            });
        });
    </script>
@endpush