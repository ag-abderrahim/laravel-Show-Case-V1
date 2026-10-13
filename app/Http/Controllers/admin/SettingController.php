<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SettingController extends Controller
{
    private const FIELDS = [
        'general' => [
            'site_name' => 'nullable|string|max:150',
            'site_tagline' => 'nullable|string|max:255',
            'site_description' => 'nullable|string|max:2000',
            'site_logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'site_favicon' => 'nullable|file|mimes:png,ico,jpg,jpeg,webp|max:1024',
        ],
        'contact' => [
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:50',
            'contact_whatsapp' => 'nullable|string|max:50',
            'contact_address' => 'nullable|string|max:500',
            'contact_map' => 'nullable|url:http,https|max:2000',
        ],
        'social' => [
            'facebook_url' => 'nullable|url:http,https|max:2000',
            'instagram_url' => 'nullable|url:http,https|max:2000',
            'linkedin_url' => 'nullable|url:http,https|max:2000',
            'youtube_url' => 'nullable|url:http,https|max:2000',
            'tiktok_url' => 'nullable|url:http,https|max:2000',
        ],
        'appearance' => [
            'primary_color' => ['nullable', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'secondary_color' => ['nullable', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'accent_color' => ['nullable', 'regex:/^#[0-9a-fA-F]{6}$/'],
        ],
        'seo' => [
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            'og_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'robots_index' => 'required|boolean',
        ],
    ];

    private const IMAGES = [
        'site_logo',
        'site_favicon',
        'og_image',
    ];

    public function index()
    {
        $settings = Setting::query()
            ->pluck('value', 'key')
            ->toArray();

        return view('admin.pages.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $group = $request->input('group');

        if (!is_string($group) || !array_key_exists($group, self::FIELDS)) {
            abort(404);
        }

        $rules = self::FIELDS[$group];

        $data = $request->validate($rules);

        foreach ($rules as $key => $rule) {

            if (in_array($key, self::IMAGES, true)) {
                continue;
            }

            $value = $data[$key] ?? null;

            if ($key === 'robots_index') {
                $value = (bool) $value;
            }

            Setting::setValue(
                $key,
                $value,
                $group,
                $this->fieldType($key)
            );
        }

        foreach (self::IMAGES as $key) {

            if (!array_key_exists($key, $rules)) {
                continue;
            }

            if (!$request->hasFile($key)) {
                continue;
            }

            $oldPath = Setting::getValue($key);

            $newPath = $request->file($key)
                ->store('settings', 'public');

            Setting::setValue(
                $key,
                $newPath,
                $group,
                'image'
            );

            if (is_string($oldPath) && $oldPath !== $newPath) {
                Storage::disk('public')->delete($oldPath);
            }
        }

        return redirect()
            ->route('settings.index', ['tab' => $group])
            ->with('success', 'Settings updated successfully.');
    }

    public function destroyImage(string $key)
    {
        if (!in_array($key, self::IMAGES, true)) {
            abort(404);
        }

        $path = Setting::getValue($key);

        $setting = Setting::where('key', $key)->first();

        if ($setting) {
            $setting->update(['value' => null]);
        }

        if (is_string($path) && $path !== '') {
            Storage::disk('public')->delete($path);
        }

        return back()->with('success', 'Image removed successfully.');
    }

    private function fieldType(string $key): string
    {
        if (str_ends_with($key, '_color')) {
            return 'color';
        }

        if (str_ends_with($key, '_url') || $key === 'contact_map') {
            return 'url';
        }

        if ($key === 'robots_index') {
            return 'boolean';
        }

        if (in_array($key, ['site_description', 'contact_address', 'meta_description'], true)) {
            return 'textarea';
        }

        if (str_contains($key, 'email')) {
            return 'email';
        }

        return 'text';
    }
}
