@empty($pelatihan)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/pelatihan') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/pelatihan/' . $pelatihan->id_pelatihan . '/delete') }}" method="POST" id="form-delete">
        @csrf
        @method('DELETE')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Data pelatihan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <table class="table table-sm table-bordered table-striped">
                        <tr>
                            <th class="text-right col-3">ID</th>
                            <td class="col-9">{{ $pelatihan->id_pelatihan }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Vendor</th>
                            <td class="col-9">{{ $pelatihan->vendor_pelatihan->nama }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Jenis Bidang</th>
                            <td class="col-9">{{ $pelatihan->jenis_pelatihan->nama_jenis_pelatihan }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Tahun Periode</th>
                            <td class="col-9">{{ $pelatihan->periode->tahun_periode }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Nama pelatihan</th>
                            <td class="col-9">{{ $pelatihan->nama_pelatihan }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Level Pealtihan</th>
                            <td class="col-9">{{ $pelatihan->level_pelatihan }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Lokasi</th>
                            <td class="col-9">{{ $pelatihan->lokasi }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Tanggal</th>
                            <td class="col-9">{{ $pelatihan->tanggal }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Kuota Peserta</th>
                            <td class="col-9">{{ $pelatihan->kuota_peserta }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Biaya</th>
                            <td class="col-9">{{ $pelatihan->biaya }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Bidang Minat</th>
                            <td class="col-9">{{ $pelatihan->bidang_minat_pelatihan->pluck('nama_bidang_minat')->implode(', '); }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Mata Kuliah</th>
                            <td class="col-9">{{ $pelatihan->mata_kuliah_pelatihan->pluck('nama_matakuliah')->implode(', '); }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Bukti Pelatihan</th>
                            <td class="col-9">
                                @if (!empty($pelatihan->bukti_pelatihan))
                                    @php
                                        // Ambil nama file tanpa path
                                        $fullFileName = basename($pelatihan->bukti_pelatihan);
                                        
                                        // Hilangkan tanggal di depan
                                        $cleanFileName = preg_replace('/^\d{10}_/', '', $fullFileName);
                                    @endphp
                        
                                    <a href="{{ url('storage/images/' . $pelatihan->bukti_pelatihan) }}" target="_blank" download>
                                        {{ $cleanFileName }}
                                    </a>
                                @else
                                    <span class="text-danger">Tidak ada bukti pelatihan</span>
                                @endif
                            </td>
                        </tr>
                        </table>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                    <button type="submit" class="btn btn-primary">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </form>
    <script>
        $(document).ready(function() {
            $("#form-delete").validate({
                rules: {},
                submitHandler: function(form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function(response) {
                            if (response.status) {
                                $('#myModal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                });
                                dataPelatihan.ajax.reload();
                            } else {
                                $('.error-text').text('');
                                $.each(response.msgField, function(prefix, val) {
                                    $('#error-' + prefix).text(val[0]);
                                });
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan',
                                    text: response.message
                                });
                            }
                        }
                    });
                    return false;
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@endempty
