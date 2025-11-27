<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Logika pengarahan berdasarkan Role (Sesuai Soal Project 8)
        switch ($user->role) {
            case 'admin':
                return view('admin.dashboard');
                break;
            case 'hr':
                return view('hr.dashboard');
                break;
            case 'division_manager':
                return view('manager.dashboard');
                break;
            case 'employee':
                return view('employee.dashboard');
                break;
            default:
                // Jika role tidak dikenal, lempar ke halaman login lagi
                return redirect()->route('login');
        }
    }
}