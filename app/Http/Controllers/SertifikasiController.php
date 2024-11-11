<?php

namespace App\Http\Controllers;

use App\Models\VendorPelatihanModel;
use App\Models\VendorSertifikasiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class SertifikasiController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Sertifikasi',
            'list'  => ['Home', 'Sertifikasi']
        ];

        $page = (object) [
            'title' => 'Daftar user yang terdaftar dalam sistem'
        ];

        $activeMenu = 'user';

        $vendorSertifikasi = VendorSertifikasiModel::all();
        $vendorPelatihan = VendorPelatihanModel::all();

        return view('user.index', [
            'breadcrumb' => $breadcrumb, 
            'page' => $page, 
            'vendorSertifikasi' => $vendorSertifikasi,
            'vendorPelatihan' => $vendorPelatihan,
            'activeMenu' => $activeMenu
        ]);
    }
}
