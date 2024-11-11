<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\MataKuliahModel;
use Illuminate\Http\Request;

class MataKuliahController extends Controller
{
    public function index()
    {
        return MataKuliahModel::all();
    }
    public function store(Request $request)
    {
        $mataKuliah = MataKuliahModel::create($request->all());
        return response()->json($mataKuliah, 201);
    }
    public function show(MataKuliahModel $mataKuliah)
    {
        return MataKuliahModel::find($mataKuliah);
    }
    public function update(Request $request, MataKuliahModel $mataKuliah)
    {
        $mataKuliah->update($request->all());
        return MataKuliahModel::find($mataKuliah);
    }
    public function destroy(MataKuliahModel $mataKuliah)
    {
        $mataKuliah->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data terhapus',
        ]);
    }
}
