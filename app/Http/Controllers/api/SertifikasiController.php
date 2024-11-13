<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BidangMinatSertifikasiModel;
use App\Models\MataKuliahSertifikasiModel;
use App\Models\SertifikasiModel;
use Illuminate\Http\Request;

class SertifikasiController extends Controller
{
    public function index()
    {
        return SertifikasiModel::all();
    }
    public function store(Request $request)
    {
        $sertifikasi = SertifikasiModel::create($request->all());
        $sertifikasi->bidang_minat_sertifikasi()->sync($request->id_bidang_minat);
        $sertifikasi->mata_kuliah_sertifikasi()->sync($request->id_matakuliah);
        
        return response()->json($sertifikasi, 201);
    }
    public function show(SertifikasiModel $sertifikasi)
    {
        return SertifikasiModel::find($sertifikasi);
        return BidangMinatSertifikasiModel::find($sertifikasi);
        return MataKuliahSertifikasiModel::find($sertifikasi);
    }
    public function update(Request $request, SertifikasiModel $sertifikasi)
    {
        $sertifikasi->update($request->all());
        $sertifikasi->bidang_minat_sertifikasi()->sync($request->id_bidang_minat);
        $sertifikasi->mata_kuliah_sertifikasi()->sync($request->id_matakuliah);

        return SertifikasiModel::find($sertifikasi);
    }
    public function destroy(SertifikasiModel $sertifikasi)
    {
        $sertifikasi->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data terhapus',
        ]);
    }
}
