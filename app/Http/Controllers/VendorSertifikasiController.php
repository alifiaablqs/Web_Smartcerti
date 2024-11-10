<?php

namespace App\Http\Controllers;

use App\Models\VendorSertifikasiModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;

class VendorSertifikasiController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Vendor Sertifikasi',
            'list' => ['Home', 'Vendor Sertifikasi']
        ];

        $page = (object)[
            'title' => 'Daftar vendor sertifikasi yang terdaftar dalam sistem'
        ];

        $activeMenu = 'vendorsertifikasi'; //set menu yang sedang aktif

        return view('vendorsertifikasi.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    //Ambil data vendorsertifikasi dalam bentuk json untuk datables
    public function list()
    {
        $vendorsertifikasis = VendorSertifikasiModel::select('id_vendor_sertifikasi', 'nama', 'alamat', 'kota', 'no_telp', 'alamat_web');

        return DataTables::of($vendorsertifikasis)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex) 
            ->addIndexColumn()
            ->addColumn('aksi', function ($vendorsertifikasi) {
                // menambahkan kolom aksi 
                $btn = '<button onclick="modalAction(\'' . url('/vendorsertifikasi/' . $vendorsertifikasi->id_vendor_sertifikasi .
                    '/show') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/vendorsertifikasi/' . $vendorsertifikasi->id_vendor_sertifikasi .
                    '/edit') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/vendorsertifikasi/' . $vendorsertifikasi->id_vendor_sertifikasi .
                    '/confirm') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html 
            ->make(true);
    }

    public function create()
    {

        return view('vendorsertifikasi.create');
    }

    // Menyimpan data vendor sertifikasi baru ajax
    public function store(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama'   => 'required|string|max:100|unique:vendor_sertifikasi,nama',
                'alamat'   => 'required|string|max:100',
                'kota'   => 'required|string|max:100',
                'no_telp'   => 'required|string|max:20',
                'alamat_web'   => 'required|string|max:255'
            ];

            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,  // response status , false: error/gagal, true: berhasil
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(), // pesan error validasi
                ]);
            }

            VendorSertifikasiModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data vendor sertifikasi berhasil disimpan'
            ]);
        }
        redirect('/');
    }

    // Menampilkan detail vendor sertifikasi
    public function show(String $id)
    {
        $vendorsertifikasi = VendorSertifikasiModel::find($id);

        return view('vendorsertifikasi.show', ['vendorsertifikasi' => $vendorsertifikasi]);
    }

    // Menampilkan halaman form edit vendor sertifikasi
    public function edit(String $id)
    {
        $vendorsertifikasi = VendorSertifikasiModel::find($id);

        return view('vendorsertifikasi.edit', ['vendorsertifikasi' => $vendorsertifikasi]);
    }


    // Menyimpan perubahan data vendor sertifikasi
    public function update(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama'   => 'required|string|max:100',
                'alamat'   => 'required|string|max:100',
                'kota'   => 'required|string|max:100',
                'no_telp'   => 'required|string|max:20',
                'alamat_web'   => 'required|string|max:255'
            ];

            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // respon json, true: berhasil, false: gagal
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors() // menunjukkan field mana yang error
                ]);
            }
            $check = VendorSertifikasiModel::find($id);
            if ($check) {
                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }

    // Menampilkan hapus data vendor sertifikasi ajax
    public function confirm(string $id) {
        $vendorsertifikasi = VendorSertifikasiModel::find($id);
        
        return view('vendorsertifikasi.confirm', ['vendorsertifikasi' => $vendorsertifikasi]);
    }

    // Menghapus data vendor sertifikasi ajax
    public function delete(Request $request, $id) {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $vendorsertifikasi = VendorSertifikasiModel::find($id);
            if ($vendorsertifikasi) {
                $vendorsertifikasi->delete();
                return response()->json([
                    'status'    => true,
                    'message'   => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }
}
