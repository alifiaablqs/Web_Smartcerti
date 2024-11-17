<?php
namespace App\Http\Controllers;

use App\Models\PelatihanModel;
use App\Models\SertifikasiModel;

class DashboardPimpinanController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Selamat Datang',
            'list' => ['Home', 'Welcome']
        ];

        $activeMenu = 'dashboard';
        // Hitung jumlah data sertifikasi dosen
        $jumlahSertifikasi = SertifikasiModel::count();

         // Hitung jumlah data pelatihan dosen
         $jumlahPelatihan = PelatihanModel::count();

        // Kirim data ke view
        return view('dashboardpimpinan', [
            'breadcrumb' => $breadcrumb,
            'activeMenu' => $activeMenu,
            'jumlahPelatihan' => $jumlahPelatihan,
            'jumlahSertifikasi' => $jumlahSertifikasi // Kirim jumlah sertifikasi ke view
        ]);
        }
}
