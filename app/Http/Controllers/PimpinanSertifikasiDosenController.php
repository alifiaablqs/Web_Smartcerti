<?php

namespace App\Http\Controllers;

use App\Models\SertifikasiModel;
use App\Models\VendorPelatihanModel;
use App\Models\VendorSertifikasiModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PimpinanSertifikasiDosenController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Sertifikasi Dosen',
            'list'  => ['Home', 'Sertifikasi Dosen']
        ];

        $page = (object) [
            'title' => 'Daftar sertifikasi dosen yang terdaftar dalam sistem'
        ];

        $activeMenu = 'dashboardpimpinan';

        $vendorSertifikasi = VendorSertifikasiModel::all();
        $vendorPelatihan = VendorPelatihanModel::all();

        return view('pimpinansertifikasidosen.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'vendorSertifikasi' => $vendorSertifikasi,
            'vendorPelatihan' => $vendorPelatihan,
            'activeMenu' => $activeMenu
        ]);
    }

    public function list()
    {
        // Mengambil semua data sertifikasi dengan relasi
        $sertifikasis = SertifikasiModel::select(
            'id_sertifikasi',
            'id_vendor_sertifikasi',
            'id_jenis_sertifikasi',
            'id_periode',
            'nama_sertifikasi',
            'no_sertifikasi',
            'jenis',
            'tanggal',
            'bukti_sertifikasi',
            'masa_berlaku',
            'kuota_peserta',
            'biaya'
        )
            ->with('vendor_sertifikasi', 'jenis_sertifikasi', 'periode', 'bidang_minat_sertifikasi', 'mata_kuliah_sertifikasi', 'detail_peserta_sertifikasi');
        

        return DataTables::of($sertifikasis)
            ->addIndexColumn()
            ->addColumn('bidang_minat', function ($sertifikasi) {
                return $sertifikasi->bidang_minat_sertifikasi
                    ? $sertifikasi->bidang_minat_sertifikasi->pluck('nama_bidang_minat')->implode(', ')
                    : '-';
            })
            ->addColumn('mata_kuliah', function ($sertifikasi) {
                return $sertifikasi->mata_kuliah_sertifikasi
                    ? $sertifikasi->mata_kuliah_sertifikasi->pluck('nama_matakuliah')->implode(', ')
                    : '-';
            })
            ->addColumn('peserta_sertifikasi', function ($sertifikasi) {
                return $sertifikasi->detail_peserta_sertifikasi
                    ? $sertifikasi->detail_peserta_sertifikasi->pluck('nama_lengkap')->implode(', ')
                    : '-';
            })
            ->make(true);
    }
}
