<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    use \App\Traits\LogActivity;

    public function index()
    {
        $settings = Setting::orderBy('group')->orderBy('order')->get()->groupBy('group');
        return view('dashboard.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'settings.*' => 'nullable',
            'settings.logo' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
        ]);

        $allSettings = Setting::all();

        foreach ($allSettings as $setting) {

            $key = $setting->key;

            if ($setting->type === 'boolean') {
                $value = $request->has("settings.$key") ? '1' : '0';
                $setting->update(['value' => $value]);
                continue;
            }

            if ($setting->type === 'image' && $request->hasFile("settings.$key")) {

                if ($setting->value) {
                    Storage::disk('public')->delete($setting->value);
                }

                $path = $request->file("settings.$key")->store('settings', 'public');
                $setting->update(['value' => $path]);
                continue;
            }

            if ($request->has("settings.$key")) {
                $setting->update(['value' => $request->input("settings.$key")]);
            }
        }

        Cache::forget('settings');

        $this->logActivity('settings_updated', 'تم تحديث الإعدادات العامة للنظام');

        return redirect()->back()->with('toast', [
            'type' => 'success',
            'message' => 'تم حفظ الإعدادات بنجاح'
        ]);
    }

}