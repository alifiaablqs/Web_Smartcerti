@extends('layouts.template')

@section('title')| Sertifikasi @endsection

@section('content')
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" data-width="75%" aria-hidden="true"></div>
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <button onclick="modalAction(`{{ url('/sertifikasi/create') }}`)" class="btn btn-success" style="background-color: #EF5428; border-color: #EF5428;">Tambah</button>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            {{-- <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Filter:</label>
                        <div class="col-3">
                            <select class="form-control" id="id_level" name="id_level" required>
                                <option value="">- Semua -</option>
                                @foreach ($level as $item)
                                    <option value="{{ $item->id_level }}">{{ $item->nama_level }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Level Pengguna</small>
                        </div>
                    </div>
                </div>
            </div> --}}
            <table class="table table-bordered table-striped table-hover table-sm" id="table_sertifikasi">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Vendor</th>
                        <th>Jenis Bidang</th>
                        <th>Periode</th>
                        <th>Nama Sertifikasi</th>
                        <th>No Sertifikasi</th>
                        <th>Jenis</th>
                        <th>Tanggal</th>
                        <th>Bukti Sertifikasi</th>
                        <th>Masa Berlaku</th>
                        {{-- <th>Kuota Peserta</th>
                        <th>Biaya</th> --}}
                        <th>Tag Bidang Minat</th>
                        <th>Tag Mata Kuliah</th>
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
        var dataSertifikasi;
        $(document).ready(function() {
            dataSertifikasi = $('#table_sertifikasi').DataTable({
                // serverSide: true, jika ingin menggunakan server side processing
                serverSide: true,
                ajax: {
                    "url": "{{ url('sertifikasi/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    // "data": function(d) {
                    //     d.level_id = $('#id_level').val();
                    // }
                },
                columns: [{
                    data: "DT_RowIndex",
                    className: "text-center",
                    width: "5%",
                    orderable: false,
                    searchable: false
                }, {
                    data: "vendor_sertifikasi.nama",
                    className: "",
                    width: "9%",
                    orderable: false,
                    searchable: true
                }, 
                {
                    data: "jenis_sertifikasi.nama_jenis_sertifikasi",
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
                    data: "nama_sertifikasi",
                    className: "",
                    width: "9%",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "no_sertifikasi",
                    className: "",
                    width: "8%",
                    orderable: false,
                    searchable: true
                },
                {
                    data: "jenis",
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
                    data: "bukti_sertifikasi",
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
                    data: "bidang_minat_sertifikasi.id_bidang_minat",
                    className: "",
                    width: "6%",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "mata_kuliah_sertifikasi.id_matakuliah",
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