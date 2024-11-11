@empty($bidangMinat)
    <div id="modal-bidang-minat" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/bidangminat') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <div id="modal-bidang-minat" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Data Bidang Minat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-sm table-bordered table-striped">
                    <tr>
                        <th class="text-right col-3">ID</th>
                        <td class="col-9">{{ $bidangMinat->id_bidang_minat }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Kode Bidang Minat</th>
                        <td class="col-9">{{ $bidangMinat->kode_bidang_minat }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Nama Bidang Minat</th>
                        <td class="col-9">{{ $bidangMinat->nama_bidang_minat }}</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn" style="color: white; background-color: #EF5428; border-color: #EF5428;">Kembali</button>
            </div>
        </div>
    </div>
@endempty
