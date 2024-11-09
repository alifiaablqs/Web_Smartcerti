<?php
namespace App\Http\Controllers;

class DashboardPimpinanController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Selamat Datang',
            'list' => ['Home', 'Welcome']
        ];

        $activeMenu = 'dashboard';

        return view('dashboardpimpinan', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);
    }

}
