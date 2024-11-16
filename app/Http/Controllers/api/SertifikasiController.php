<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BidangMinatSertifikasiModel;
use App\Models\MataKuliahSertifikasiModel;
use App\Models\SertifikasiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SertifikasiController extends Controller
{
    public function index()
    {
        return SertifikasiModel::all();
    }
    public function store(Request $request)
    {
        // Inisialisasi variabel untuk menyimpan path file
        $bukti_sertifikasi = null;

        // Cek apakah file bukti sertifikasi diunggah
        if ($request->hasFile('bukti_sertifikasi')) {
            $bukti_sertifikasi = time() . '_' . $request->file('bukti_sertifikasi')->getClientOriginalName();
            $request->file('bukti_sertifikasi')->storeAs('public/images/', $bukti_sertifikasi);
        }

        $sertifikasi = SertifikasiModel::create([
            'nama_sertifikasi'  => $request->nama_sertifikasi,
            'no_sertifikasi'      => $request->no_sertifikasi,
            'jenis'      => $request->jenis,
            'tanggal'      => $request->tanggal,
            'bukti_sertifikasi'      => $bukti_sertifikasi,
            'masa_berlaku'      => $request->masa_berlaku,
            'kuota_peserta'      => $request->kuota_peserta,
            'biaya'      => $request->biaya,
            'id_vendor_sertifikasi'  => $request->id_vendor_sertifikasi,
            'id_jenis_sertifikasi'  => $request->id_jenis_sertifikasi,
            'id_periode'  => $request->id_periode
        ]);
        $sertifikasi->bidang_minat_sertifikasi()->sync($request->id_bidang_minat);
        $sertifikasi->mata_kuliah_sertifikasi()->sync($request->id_matakuliah);

        $userId = Auth::user();

        $sertifikasi->detail_peserta_sertifikasi()->attach($userId);

        return response()->json($sertifikasi, 201);
    }
    public function show(SertifikasiModel $sertifikasi)
    {
        return SertifikasiModel::find($sertifikasi)->with('vendor_sertifikasi', 'jenis_sertifikasi', 'periode', 'bidang_minat_sertifikasi', 'mata_kuliah_sertifikasi');
    }
    public function update(Request $request, SertifikasiModel $sertifikasi)
    {
        $bukti_sertifikasi = null;

        if ($request->hasFile('bukti_sertifikasi')) {
            $bukti_sertifikasi = time() . '_' . $request->file('bukti_sertifikasi')->getClientOriginalName();
            $request->file('bukti_sertifikasi')->storeAs('public/images/', $bukti_sertifikasi);
        }
        if ($request->hasFile('bukti_sertifikasi')) {
            $sertifikasi->update([
                'nama_sertifikasi'  => $request->nama_sertifikasi,
                'no_sertifikasi'      => $request->no_sertifikasi,
                'jenis'      => $request->jenis,
                'tanggal'      => $request->tanggal,
                'bukti_sertifikasi'      => $bukti_sertifikasi,
                'masa_berlaku'      => $request->masa_berlaku,
                'kuota_peserta'      => $request->kuota_peserta,
                'biaya'      => $request->biaya,
                'id_vendor_sertifikasi'  => $request->id_vendor_sertifikasi,
                'id_jenis_sertifikasi'  => $request->id_jenis_sertifikasi,
                'id_periode'  => $request->id_periode
            ]);
        } else {
            $sertifikasi->update([
                'nama_sertifikasi'  => $request->nama_sertifikasi,
                'no_sertifikasi'      => $request->no_sertifikasi,
                'jenis'      => $request->jenis,
                'tanggal'      => $request->tanggal,
                'masa_berlaku'      => $request->masa_berlaku,
                'kuota_peserta'      => $request->kuota_peserta,
                'biaya'      => $request->biaya,
                'id_vendor_sertifikasi'  => $request->id_vendor_sertifikasi,
                'id_jenis_sertifikasi'  => $request->id_jenis_sertifikasi,
                'id_periode'  => $request->id_periode
            ]);
        }
        $sertifikasi->bidang_minat_sertifikasi()->sync($request->id_bidang_minat);
        $sertifikasi->mata_kuliah_sertifikasi()->sync($request->id_matakuliah);

        return SertifikasiModel::find($sertifikasi);
    }
    public function destroy(SertifikasiModel $sertifikasi)
    {
        if ($sertifikasi) {
            // Hapus relasi many-to-many dengan MataKuliah dan BidangMinat
            $sertifikasi->mata_kuliah_sertifikasi()->detach();
            $sertifikasi->bidang_minat_sertifikasi()->detach();

            // Hapus data sertifikasi
            $sertifikasi->delete();

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil dihapus'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
    }
}
