<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // auth()->user() akan otomatis mengambil data admin yang login
        $admin = auth()->user();
        return view('admin.dashboard', compact('admin'));
    }
}