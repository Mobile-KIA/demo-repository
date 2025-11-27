<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function orangTua()
    {
        return view('dashboard.orangtua');
    }

    public function tenagaMedis()
    {
        return view('dashboard.tenagamedis');
    }
}
