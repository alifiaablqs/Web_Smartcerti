<?php

namespace App\Http\Controllers;

use App\Models\PelatihanModel;
use App\Models\SertifikasiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PenerimaanPermintaanController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Penerimaan Permintaan',
            'list'  => ['Home', 'Penerimaan Permintaan']
        ];

        $page = (object) [
            'title' => 'Daftar penerimaan permintaan yang terdaftar dalam sistem'
        ];

        $activeMenu = 'penerimaanpermintaan';

        return view('penerimaanpermintaan.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

    public function list()
    {
        // Ambil data dari tabel sertifikasi
        $sertifikasi = SertifikasiModel::select(
            'id_sertifikasi as id',
            'id_vendor_sertifikasi',
            'id_jenis_sertifikasi',
            'id_periode',
            'nama_sertifikasi as nama_program',
            'jenis as jenis_level',
            'tanggal',
            'kuota_peserta',
            'biaya',
            DB::raw("'sertifikasi' as kategori")
        )
        ->whereHas('detail_peserta_sertifikasi', function($query) {
            $query->where('status_sertifikasi', 'menunggu');
        })
        ->with('vendor_sertifikasi', 'jenis_sertifikasi', 'periode');
        
        // Ambil data dari tabel pelatihan
        $pelatihan = PelatihanModel::select(
            'id_pelatihan as id',
            'id_vendor_pelatihan as id_vendor_sertifikasi',
            'id_jenis_pelatihan as id_jenis_sertifikasi',
            'id_periode',
            'nama_pelatihan as nama_program',
            'level_pelatihan as jenis_level',
            'tanggal',
            'kuota_peserta',
            'biaya',
            DB::raw("'pelatihan' as kategori")
        )
        ->whereHas('detail_peserta_pelatihan', function($query) {
            $query->where('status_pelatihan', 'menunggu');
        })
        ->with('vendor_pelatihan', 'jenis_pelatihan', 'periode');
    
        // Gabungkan data sertifikasi dan pelatihan
        $data = $sertifikasi->union($pelatihan)->get();
    
        // Mengembalikan data dengan DataTables
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                $btn = '<button onclick="modalAction(\'' . url('/detail/' . $row->id . '/show') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
}
