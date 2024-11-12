<?php

namespace App\Http\Controllers;

use App\Models\BidangMinatModel;
use App\Models\BidangMinatSertifikasiModel;
use App\Models\JenisSertifikasiModel;
use App\Models\MataKuliahModel;
use App\Models\MataKuliahSertifikasiModel;
use App\Models\PeriodeModel;
use App\Models\SertifikasiModel;
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
            'title' => 'Daftar sertifikasi yang terdaftar dalam sistem'
        ];

        $activeMenu = 'sertifikasi';

        $vendorSertifikasi = VendorSertifikasiModel::all();
        $vendorPelatihan = VendorPelatihanModel::all();

        return view('sertifikasi.index', [
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
            'biaya',
            )
            ->with('vendor_sertifikasi', 'jenis_sertifikasi', 'periode');

        $bidangMinats = BidangMinatSertifikasiModel::select(
            'id_sertifikasi',
            'id_bidang_minat'
        )
        ->with('sertifikasi', 'bidang_minat');

        $mataKuliahs = MataKuliahSertifikasiModel::select(
            'id_sertifikasi',
            'id_matakuliah'
        )
        ->with('sertifikasi', 'mata_kuliah');

        // // Filter data user berdasarkan id_level jika ada
        // if ($request->id_level) {
        //     $users->where('id_level', $request->id_level);
        // }

        // Mengembalikan data dengan DataTables
        return DataTables::of($sertifikasis, $bidangMinats, $mataKuliahs)
            ->addIndexColumn()
            ->addColumn('aksi', function ($sertifikasi) {
                $btn = '<button onclick="modalAction(\'' . url('/sertifikasi/' . $sertifikasi->id_sertifikasi . '/show') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/sertifikasi/' . $sertifikasi->id_sertifikasi . '/edit') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/sertifikasi/' . $sertifikasi->id_sertifikasi . '/confirm') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        // Mengambil id_level dan nama_level dari tabel level
        $vendorSertifikasi = VendorSertifikasiModel::select('id_vendor_sertifikasi', 'nama')->get();
        $jenisSertifikasi = JenisSertifikasiModel::select('id_jenis_sertifikasi', 'nama_jenis_sertifikasi')->get();
        $periode = PeriodeModel::select('id_periode', 'tahun_periode')->get();

        $bidangMinat = BidangMinatModel::select('id_bidang_minat', 'nama_bidang_minat')->get();
        $mataKuliah = MataKuliahModel::select('id_matakuliah', 'nama_matakuliah')->get();
        // dd($mataKuliah);

        return view('sertifikasi.create')->with([
            'vendorSertifikasi' => $vendorSertifikasi,
            'jenisSertifikasi' => $jenisSertifikasi,
            'periode' => $periode,
            'bidangMinat' => $bidangMinat,
            'mataKuliah' => $mataKuliah,
        ]);
    }
    
    public function store(Request $request) 
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'id_vendor_sertifikasi' => 'required|integer',
                'id_jenis_sertifikasi' => 'required|integer',
                'id_periode' => 'required|integer',

                'id_bidang_minat' => 'required|integer',
                'id_matakuliah' => 'required|integer',

                'nama_sertifikasi' => 'required|string|min:5',
                'no_sertifikasi' => 'required|string|max:255',
                'jenis' => 'required',
                'tanggal' => 'required|date',
                'bukti_sertifikasi' => 'nullable|string|max:255',
                'masa_berlaku' => 'required',
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
            SertifikasiModel::create([
                'nama_sertifikasi'  => $request->nama_sertifikasi,
                'no_sertifikasi'      => $request->no_sertifikasi,
                'jenis'      => $request->jenis,
                'tanggal'      => $request->tanggal,
                'bukti_sertifikasi'      => $request->bukti_sertifikasi,
                'masa_berlaku'      => $request->masa_berlaku,
                'kuota_peserta'      => $request->kuota_peserta,
                'biaya'      => $request->biaya,
                'id_vendor_sertifikasi'  => $request->id_vendor_sertifikasi,
                'id_jenis_sertifikasi'  => $request->id_jenis_sertifikasi,
                'id_periode'  => $request->id_periode
            ]);

            BidangMinatSertifikasiModel::create([
                'id_sertifikasi' => $request->id_sertifikasi,
                'id_bidang_minat' => $request->id_bidang_minat
            ]);

            MataKuliahSertifikasiModel::create([
                'id_sertifikasi' => $request->id_sertifikasi,
                'id_matakuliah' => $request->id_matakuliah
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Data user berhasil disimpan'
            ]);
        }
        return redirect('/');
    }
}
