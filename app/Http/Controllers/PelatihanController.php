<?php

namespace App\Http\Controllers;

use App\Models\BidangMinatModel;
use App\Models\BidangMinatpelatihanModel;
use App\Models\JenisPelatihanModel;
use App\Models\MataKuliahModel;
use App\Models\MataKuliahPelatihanModel;
use App\Models\PeriodeModel;
use App\Models\PelatihanModel;
use App\Models\VendorPelatihanModel;
use App\Models\VendorSertifikasiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PelatihanController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Pelatihan',
            'list'  => ['Home', 'Pelatihan']
        ];

        $page = (object) [
            'title' => 'Daftar pelatihan yang terdaftar dalam sistem'
        ];

        $activeMenu = 'pelatihan';

        $vendorSertifikasi = VendorSertifikasiModel::all();
        $vendorPelatihan = VendorPelatihanModel::all();

        return view('pelatihan.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'vendorSertifikasi' => $vendorSertifikasi,
            'vendorPelatihan' => $vendorPelatihan,
            'activeMenu' => $activeMenu
        ]);
    }

    // Ambil data user dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        // Mengambil data user beserta level
        $pelatihans = PelatihanModel::select(
            'id_pelatihan',
            'id_vendor_pelatihan',
            'id_jenis_pelatihan',
            'id_periode',
            'nama_pelatihan',
            'lokasi',
            'level_pelatihan',
            'tanggal',
            'bukti_pelatihan',
            'kuota_peserta',
            'biaya',
            )
            ->with('vendor_pelatihan', 'jenis_pelatihan', 'periode');
        // Mengembalikan data dengan DataTables
        return DataTables::of($pelatihans)
            ->addIndexColumn()
            ->addColumn('aksi', function ($pelatihan) {
                $btn = '<button onclick="modalAction(\'' . url('/pelatihan/' . $pelatihan->id_pelatihan . '/show') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/pelatihan/' . $pelatihan->id_pelatihan . '/edit') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/pelatihan/' . $pelatihan->id_pelatihan . '/confirm') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        // Mengambil id_level dan nama_level dari tabel level
        $vendorpelatihan = VendorPelatihanModel::select('id_vendor_pelatihan', 'nama')->get();
        $jenispelatihan = JenisPelatihanModel::select('id_jenis_pelatihan', 'nama_jenis_pelatihan')->get();
        $periode = PeriodeModel::select('id_periode', 'tahun_periode')->get();

        return view('pelatihan.create')->with([
            'vendorpelatihan' => $vendorpelatihan,
            'jenispelatihan' => $jenispelatihan,
            'periode' => $periode,
        ]);
    }
    
    public function store(Request $request) 
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'id_vendor_pelatihan' => 'required|integer',
                'id_jenis_pelatihan' => 'required|integer',
                'id_periode' => 'required|integer',
                'nama_pelatihan' => 'required|string|min:5',
                'level_pelatihan' => 'required',
                'lokasi' => 'required',
                'tanggal' => 'required|date',
                'bukti_pelatihan' => 'nullable|string|max:255',
                'kuota_peserta' => 'nullable|integer',
                'biaya' => 'required|string|max:255',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            // Simpan data user dengan hanya field yang diperlukan
            $pelatihan = PelatihanModel::create([
                'nama_pelatihan'  => $request->nama_pelatihan,
                'jenis'      => $request->jenis,
                'lokasi'      => $request->lokasi,
                'tanggal'      => $request->tanggal,
                'bukti_pelatihan'      => $request->bukti_pelatihan,
                'kuota_peserta'      => $request->kuota_peserta,
                'biaya'      => $request->biaya,
                'id_vendor_pelatihan'  => $request->id_vendor_pelatihan,
                'id_jenis_pelatihan'  => $request->id_jenis_pelatihan,
                'id_periode'  => $request->id_periode
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Data user berhasil disimpan'
            ]);
        }
        return redirect('/');
    }
}
