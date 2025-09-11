<?php

namespace App\Http\Controllers;

use App\Models\Gaji;
use App\Models\Lembur;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            return redirect()->route('dashboard')->with('success', 'Login Berhasil');
        }

        return redirect()->back()->withInput()->with('error', 'login gagal');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Logout Berhasil');
    }

    public function dashboard()
    {
        $user = Auth::user();

        if (!$user) {
            abort(403);
        }

        if ($user->role === 'user') {
            // Statistik umum untuk user
            $totalPegawai = Pegawai::count();
            $totalLembur = Lembur::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count();
            $totalGaji = Gaji::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('gaji_diterima');

            // Data grafik (6 bulan terakhir)
            $gajiPerBulan = Gaji::selectRaw('YEAR(created_at) as tahun, MONTH(created_at) as bulan, SUM(gaji_diterima) as total')
                ->where('created_at', '>=', now()->subMonths(6))
                ->groupByRaw('YEAR(created_at), MONTH(created_at)')
                ->orderByRaw('tahun, bulan')
                ->get();

            $lemburPerBulan = Lembur::selectRaw('YEAR(created_at) as tahun, MONTH(created_at) as bulan, COUNT(*) as total')
                ->where('created_at', '>=', now()->subMonths(6))
                ->groupByRaw('YEAR(created_at), MONTH(created_at)')
                ->orderByRaw('tahun, bulan')
                ->get();

            $labels = collect();
            $dataGaji = collect();
            $dataLembur = collect();

            foreach ($gajiPerBulan as $row) {
                $labels->push(Carbon::create()->month($row->bulan)->format('M') . ' ' . $row->tahun);
                $dataGaji->push($row->total);

                $lemburRow = $lemburPerBulan->first(function ($l) use ($row) {
                    return $l->tahun == $row->tahun && $l->bulan == $row->bulan;
                });
                $dataLembur->push($lemburRow->total ?? 0);
            }

            return view('user.dashboard', [
                'totalPegawai' => $totalPegawai,
                'totalLembur' => $totalLembur,
                'totalGaji' => $totalGaji,
                'labels' => $labels,
                'dataGaji' => $dataGaji,
                'dataLembur' => $dataLembur,
            ]);
        } else if ($user->role === 'admin') {
            // Statistik admin (lebih detail)
            $totalPegawai = Pegawai::count();
            $totalUser = User::count();
            $totalLembur = Lembur::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count();
            $totalGaji = Gaji::sum('gaji_diterima');

            $gajiPerBulan = Gaji::selectRaw('YEAR(created_at) as tahun, MONTH(created_at) as bulan, SUM(gaji_diterima) as total')
                ->where('created_at', '>=', now()->subMonths(6))
                ->groupByRaw('YEAR(created_at), MONTH(created_at)')
                ->orderByRaw('tahun, bulan')
                ->get();

            $lemburPerBulan = Lembur::selectRaw('YEAR(created_at) as tahun, MONTH(created_at) as bulan, COUNT(*) as total')
                ->where('created_at', '>=', now()->subMonths(6))
                ->groupByRaw('YEAR(created_at), MONTH(created_at)')
                ->orderByRaw('tahun, bulan')
                ->get();

            $labels = collect();
            $dataGaji = collect();
            $dataLembur = collect();

            foreach ($gajiPerBulan as $row) {
                $labels->push(Carbon::create()->month($row->bulan)->format('M') . ' ' . $row->tahun);
                $dataGaji->push($row->total);

                $lemburRow = $lemburPerBulan->first(function ($l) use ($row) {
                    return $l->tahun == $row->tahun && $l->bulan == $row->bulan;
                });
                $dataLembur->push($lemburRow->total ?? 0);
            }

            return view('admin.dashboard', [
                'totalPegawai' => $totalPegawai,
                'totalUser' => $totalUser,
                'totalLembur' => $totalLembur,
                'totalGaji' => $totalGaji,
                'labels' => $labels,
                'dataGaji' => $dataGaji,
                'dataLembur' => $dataLembur,
            ]);
        } else {
            abort(403);
        }
    }
}
