<form action="{{ url('/bidangminat/import_ajax') }}" method="POST" id="form-import-bidang-minat" enctype="multipart/form-data">
    @csrf
    <div id="modal-bidang-minat" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Data Bidang Minat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Download Template</label>
                    <a href="{{ asset('template_bidang_minat.xlsx') }}" class="btn btn-info btn-sm" download>
                        <i class="fa fa-file-excel"></i> Download
                    </a>
                    <small id="error-template" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Pilih File</label>
                    <input type="file" name="file_bidang_minat" id="file_bidang_minat" class="form-control" accept=".xlsx" required>
                    <small id="error-file_bidang_minat" class="error-text form-text text-danger"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary">Upload</button>
            </div>
        </div>
    </div>
</form>


<script>
    $(document).ready(function() {
        $("#form-import-bidang-minat").validate({
            rules: {
                file_bidang_minat: {
                    required: true,
                    extension: "xlsx"
                }
            },
            messages: {
                file_bidang_minat: {
                    required: "Silakan pilih file untuk diunggah.",
                    extension: "Format file harus .xlsx."
                }
            },
            submitHandler: function(form) {
                var formData = new FormData(form); // Menggunakan FormData untuk mengirim file
                
                $.ajax({
                    url: form.action,
                    type: "POST",
                    data: formData,
                    processData: false, // Menghindari pengolahan data otomatis oleh jQuery
                    contentType: false, // Agar jQuery tidak menetapkan tipe konten
                    success: function(response) {
                        if(response.status) { // Jika sukses
                            $('#modal-bidang-minat').modal('hide'); // Tutup modal
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            if (typeof dataBidangMinat !== 'undefined') {
                                dataBidangMinat.ajax.reload(); // Reload DataTable bidang minat jika ada
                            }
                        } else { // Jika ada error dari server-side
                            $('.error-text').text('');
                            if (response.msgField) {
                                $.each(response.msgField, function(prefix, val) {
                                    $('#error-' + prefix).text(val[0]);
                                });
                            }
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message || 'Gagal mengunggah data.'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal Mengunggah',
                            text: 'Terjadi kesalahan saat mengunggah file. Pastikan file sesuai format.'
                        });
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
