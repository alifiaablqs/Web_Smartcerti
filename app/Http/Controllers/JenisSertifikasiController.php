<?php

namespace App\Http\Controllers;

use App\Models\JenisSertifikasiModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class JenisSertifikasiController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Jenis Sertifikasi',
            'list' => ['Home', 'Jenis Sertifikasi']
        ];

        $page = (object)[
            'title' => 'Daftar jenis sertifikasi yang terdaftar dalam sistem'
        ];

        $activeMenu = 'jenissertifikasi';

        return view('jenissertifikasi.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    // Ambil data jenis sertifikasi dalam bentuk json untuk datatables
    public function list()
    {
        $jenisSertifikasi = JenisSertifikasiModel::select('id_jenis_sertifikasi', 'nama_jenis_sertifikasi', 'kode_jenis_sertifikasi');

        return DataTables::of($jenisSertifikasi)
            ->addIndexColumn()
            ->addColumn('aksi', function ($jenis) {
                $btn = '<button onclick="modalAction(\'' . url('/jenissertifikasi/' . $jenis->id_jenis_sertifikasi . '/show') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/jenissertifikasi/' . $jenis->id_jenis_sertifikasi . '/edit') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/jenissertifikasi/' . $jenis->id_jenis_sertifikasi . '/confirm') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        return view('jenissertifikasi.create');
    }

    // Menyimpan data jenis sertifikasi baru
    public function store(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kode_jenis_sertifikasi'   => 'required|string|min:3|unique:jenis_sertifikasi,kode_jenis_sertifikasi',
                'nama_jenis_sertifikasi'   => 'required|string|max:100'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            JenisSertifikasiModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data jenis sertifikasi berhasil disimpan'
            ]);
        }
        return redirect('/');
    }

    public function show(String $id)
    {
        $jenisSertifikasi = JenisSertifikasiModel::find($id);

        return view('jenissertifikasi.show', ['jenisSertifikasi' => $jenisSertifikasi]);
    }

    public function edit(String $id)
    {
        $jenisSertifikasi = JenisSertifikasiModel::find($id);

        return view('jenissertifikasi.edit', ['jenisSertifikasi' => $jenisSertifikasi]);
    }

    public function update(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kode_jenis_sertifikasi'   => 'required|string|min:3',
                'nama_jenis_sertifikasi'   => 'required|string|max:100'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $check = JenisSertifikasiModel::find($id);
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

    public function confirm(string $id)
    {
        $jenisSertifikasi = JenisSertifikasiModel::find($id);

        return view('jenissertifikasi.confirm', ['jenisSertifikasi' => $jenisSertifikasi]);
    }

    public function delete(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $jenisSertifikasi = JenisSertifikasiModel::find($id);
            if ($jenisSertifikasi) {
                $jenisSertifikasi->delete();
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
