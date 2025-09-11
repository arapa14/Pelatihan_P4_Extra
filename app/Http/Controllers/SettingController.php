<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Log;

class SettingController extends Controller
{
    public function index()
    {
        $settings = DB::table('settings')->pluck('value', 'key');
        return view('pages.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        try {
            $validated = $request->validate([
                'app_name' => 'required|string|max:255',
                'app_logo' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
            ]);

            // Update app_name
            DB::table('settings')
                ->where('key', 'app_name')
                ->update(['value' => $validated['app_name']]);

            // Update app_logo jika ada file baru
            if ($request->hasFile('app_logo')) {
                $path = $request->file('app_logo')->store('logo', 'public');

                DB::table('settings')
                    ->where('key', 'app_logo')
                    ->update(['value' => 'storage/' . $path]);
            }

            return redirect()->route('setting.index')->with('success', 'Pengaturan berhasil diperbarui.');
        } catch (\Throwable $e) {
            Log::error("Update setting failed: " . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui pengaturan.');
        }
    }
}
