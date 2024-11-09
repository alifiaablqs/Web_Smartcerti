<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LevelModel;
use Yajra\DataTables\Facades\DataTables;

class LevelController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Data Level',
            'list'  => ['Home', 'Level']
        ];

        $page = (object) [
            'title' => 'Daftar level yang terdaftar dalam sistem'
        ];

        $activeMenu = 'level';

        $level = LevelModel::all();

        return view('level.index', [
            'breadcrumb' => $breadcrumb, 
            'page' => $page, 
            'level' => $level,
            'activeMenu' => $activeMenu
        ]);
    }
    public function list(Request $request) 
    { 
        $level = LevelModel::select('id_level', 'kode_level', 'nama_level');

        if ($request->id_level){
            $level->where('id_level', $request->id_level);
        }

        return DataTables::of($level) 
            ->addIndexColumn()  
            ->addColumn('aksi', function ($level) { 
                $btn = '<a href="'.url('/level/' . $level->id_level).'" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="'.url('/level/' . $level->id_level . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="'.url('/level/'.$level->id_level).'">'
                    . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';

                return $btn; 
            }) 
            ->rawColumns(['aksi'])  
            ->make(true); 
    } 
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Level',
            'list'  => ['Home', 'Level', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Level Baru'
        ];

        $level = LevelModel::all();
        $activeMenu = 'level';

        return view('level.create', [
            'breadcrumb' => $breadcrumb, 
            'page' => $page, 
            'level' => $level, 
            'activeMenu' => $activeMenu
        ]);
    }

    public function create_ajax()
    {
        return view('level.create_ajax');
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'kode_level'    => 'required|string|min:3', 
            'nama_level'    => 'required|string|max:25',                   
        ]);

        levelModel::create([
            'kode_level' => $request->level_kode,
            'nama_level' => $request->level_nama,
        ]);

        return redirect('/level')->with('success', 'Data level berhasil disimpan');
    }
    public function show(string $id)
    {
        $level = LevelModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail level',
            'list'  => ['Home', 'Level', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail level'
        ];

        $activeMenu = 'level';

        return view('level.show', [
            'breadcrumb' => $breadcrumb, 
            'page' => $page, 
            'level' => $level, 
            'activeMenu' => $activeMenu
        ]);
    }
    public function edit(string $id)
    {
        $level = LevelModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit level',
            'list' => ['Home', 'Level', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Level'
        ];

        $activeMenu = 'level';

        return view('level.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'level' => $level,
            'activeMenu' => $activeMenu
        ]);
    }
    public function update(Request $request, string $id)
    {
        $request->validate([
            'kode_level' => 'required|string|min:3', 
            'nama_level' => 'required|string|max:100'
        ]);

        levelModel::find($id)->update([
            'kode_level' => $request->level_kode,
            'nama_level' => $request->level_nama
        ]);

        return redirect('/level')->with('success', 'Data level berhasil diubah');
    }
    public function destroy (string  $id)
    {
        $check = LevelModel::find($id);
        if (!$check) {
            return redirect('/level')->with('error', 'Data level tidak Ditemukan');
        } 

        try{
            levelModel::destroy($id);

            return redirect('/level')->with('success', 'Data level Berhasil dihapus');
        } catch (\Illuminate\Database\QueryException){
            return redirect('/level')->with('error', 'Data level Gagal dihapus karena terdapat Tabel lain yang terkait dengan data ini');
        }
        
    }
}

/* insert
        // DB::insert('insert into m_level(level_kode, level_nama, created_at) values(?,?,?)', ['CUS', 'Pelanggan', now()]);
        // return 'Insert data baru berhasil';

        // edit
        // $row = DB::update('update m_level set level_nama = ? where level_kode = ?', ['Customer', 'CUS']);
        // return 'Update data berhasil. Jumlah data yang diupdate: ' . $row . ' baris';

        //delete
        //$row = DB::delete('delete from m_level where level_kode = ?', ['CUS']);
        //return 'Delete data berhasil. Jumlah data yang dihapus: ' . $row . ' baris';

        $data = DB::select('select * from m_level');
        return view('level', ['data' => $data]);
        */