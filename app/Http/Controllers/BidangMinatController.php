<?php

namespace App\Http\Controllers;

use App\Models\BidangMinatModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;

class BidangMinatController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Bidang Minat',
            'list' => ['Home', 'Bidang Minat']
        ];

        $page = (object)[
            'title' => 'Daftar bidang minat yang terdaftar dalam sistem'
        ];

        $activeMenu = 'bidangminat';
        $bidang_minat = BidangMinatModel::all();

        return view('bidangminat.index', [
            'breadcrumb' => $breadcrumb, 
            'page' => $page, 
            'activeMenu' => $activeMenu,
            'bidang_minat' => $bidang_minat  // Pass the variable to the view
        ]);
    }

    // Fetch data for DataTables (AJAX)
    public function list()
    {
        $bidangMinat = BidangMinatModel::select('id_bidang_minat', 'nama_bidang_minat', 'kode_bidang_minat');

        return DataTables::of($bidangMinat)
            ->addIndexColumn()
            ->addColumn('aksi', function ($bidang) {
                $btn = '<button onclick="modalAction(\'' . url('/bidangminat/' . $bidang->id_bidang_minat . '/show') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/bidangminat/' . $bidang->id_bidang_minat . '/edit') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/bidangminat/' . $bidang->id_bidang_minat . '/confirm') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        return view('bidangminat.create');
    }

    // Store new bidang minat
    public function store(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kode_bidang_minat'   => 'required|string|min:3|unique:bidang_minat,kode_bidang_minat',
                'nama_bidang_minat' => 'required|string|max:100'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            BidangMinatModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data bidang minat berhasil disimpan'
            ]);
        }
        return redirect('/');
    }

    public function show(String $id)
    {
        $bidangMinat = BidangMinatModel::find($id);

        return view('bidangminat.show', ['bidangMinat' => $bidangMinat]);
    }

    public function edit(String $id)
    {
        $bidangMinat = BidangMinatModel::find($id);

        return view('bidangminat.edit', ['bidangMinat' => $bidangMinat]);
    }

    public function update(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kode_bidang_minat'   => 'required|string|min:3',
                'nama_bidang_minat' => 'required|string|max:100'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $bidangMinat = BidangMinatModel::find($id);
            if ($bidangMinat) {
                $bidangMinat->update($request->all());
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
        $bidangMinat = BidangMinatModel::find($id);

        return view('bidangminat.confirm', ['bidangMinat' => $bidangMinat]);
    }

    public function delete(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $bidangMinat = BidangMinatModel::find($id);
            if ($bidangMinat) {
                $bidangMinat->delete();
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

    public function export_pdf()
    {
        $bidangMinat = BidangMinatModel::select('kode_bidang_minat', 'nama_bidang_minat')
            ->orderBy('kode_bidang_minat')
            ->get();

        $pdf = Pdf::loadView('bidangminat.export_pdf', ['bidangMinat' => $bidangMinat]);
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption("isRemoteEnabled", true);

        return $pdf->stream('Data_Bidang_Minat_' . date('Y-m-d_H-i-s') . '.pdf');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_bidang_minat' => ['required', 'mimes:xlsx', 'max:1024']
            ];
            
            $validator = Validator::make($request->all(), $rules);
            
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }
            
            $file = $request->file('file_bidang_minat');
            $reader = IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray(null, false, true, true);
            $insert = [];
            
            if (count($data) > 1) {
                foreach ($data as $baris => $value) {
                    if ($baris > 1) {
                        $insert[] = [
                            'kode_bidang_minat' => $value['A'],
                            'nama_bidang_minat' => $value['B'],
                            'created_at' => now(),
                            'updated_at' => now()
                        ];
                    }
                }
                
                if (count($insert) > 0) {
                    BidangMinatModel::insertOrIgnore($insert);
                }
                
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diimport'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data yang diimport'
                ]);
            }
        }
        return redirect('/');
    }
}
