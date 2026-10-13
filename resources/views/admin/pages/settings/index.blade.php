
@extends('admin.layout.app')

@section('content')
@php
    $tabs = [
        'general' => 'General',
        'contact' => 'Contact',
        'social' => 'Social Media',
        'appearance' => 'Appearance',
        'seo' => 'SEO',
    ];

    $activeTab = request('tab', 'general');

    if (!array_key_exists($activeTab, $tabs)) {
        $activeTab = 'general';
    }

    $fields = [
        'general' => [
            ['site_name', 'Website Name', 'text'],
            ['site_tagline', 'Tagline', 'text'],
            ['site_description', 'Website Description', 'textarea'],
            ['site_logo', 'Website Logo', 'image'],
            ['site_favicon', 'Favicon', 'image'],
        ],
        'contact' => [
            ['contact_email', 'Email Address', 'email'],
            ['contact_phone', 'Phone Number', 'text'],
            ['contact_whatsapp', 'WhatsApp Number', 'text'],
            ['contact_address', 'Address', 'textarea'],
            ['contact_map', 'Google Maps URL', 'url'],
        ],
        'social' => [
            ['facebook_url', 'Facebook', 'url'],
            ['instagram_url', 'Instagram', 'url'],
            ['linkedin_url', 'LinkedIn', 'url'],
            ['youtube_url', 'YouTube', 'url'],
            ['tiktok_url', 'TikTok', 'url'],
        ],
        'appearance' => [
            ['primary_color', 'Primary Color', 'color'],
            ['secondary_color', 'Secondary Color', 'color'],
            ['accent_color', 'Accent Color', 'color'],
        ],
        'seo' => [
            ['meta_title', 'Default Meta Title', 'text'],
            ['meta_description', 'Meta Description', 'textarea'],
            ['meta_keywords', 'Meta Keywords', 'text'],
            ['og_image', 'Social Sharing Image', 'image'],
            ['robots_index', 'Allow Search Engine Indexing', 'checkbox'],
        ],
    ];
@endphp

<div class="mx-auto max-w-6xl px-4 py-8">

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">
            Website Settings
        </h1>
        <p class="mt-1 text-sm text-gray-500">
            Manage your website configuration and preferences.
        </p>
    </div>

    @if(session('success'))
        <div class="mb-6 rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-4">

        {{-- Sidebar Tabs --}}
        <div class="lg:col-span-1">
            <nav class="space-y-2 rounded-2xl border border-gray-200 bg-white p-3 shadow-sm">
                @foreach($tabs as $key => $label)
                    <a
                        href="{{ route('settings.index', ['tab' => $key]) }}"
                        class="block rounded-xl px-4 py-3 text-sm font-medium transition
                        {{ $activeTab === $key
                            ? 'bg-gray-900 text-white'
                            : 'text-gray-600 hover:bg-gray-100' }}"
                    >
                        {{ $label }}
                    </a>
                @endforeach
            </nav>
        </div>

        {{-- Settings Form --}}
        <div class="lg:col-span-3">

            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

                <div class="mb-6 border-b border-gray-100 pb-5">
                    <h2 class="text-xl font-semibold text-gray-900">
                        {{ $tabs[$activeTab] }} Settings
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">
                        Update your website {{ strtolower($tabs[$activeTab]) }} configuration.
                    </p>
                </div>

                <form
                    action="{{ route('settings.update') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="space-y-6"
                >
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="group" value="{{ $activeTab }}">

                    @foreach($fields[$activeTab] as [$key, $label, $type])
                        <div>
                            <label for="{{ $key }}" class="mb-2 block text-sm font-medium text-gray-700">
                                {{ $label }}
                            </label>

                            @if($type === 'textarea')
                                <textarea
                                    id="{{ $key }}"
                                    name="{{ $key }}"
                                    rows="4"
                                    class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900"
                                >{{ old($key, $settings[$key] ?? '') }}</textarea>

                            @elseif($type === 'image')
                                @if(!empty($settings[$key]))
                                    <div class="mb-3 flex items-center gap-4">
                                        <img
                                            src="{{ asset('storage/' . $settings[$key]) }}"
                                            alt="{{ $label }}"
                                            class="h-20 w-20 rounded-lg border border-gray-200 object-contain p-2"
                                        >

                                        <button
                                            type="submit"
                                            form="delete-{{ $key }}"
                                            onclick="return confirm('Remove this image?')"
                                            class="rounded-lg border border-red-200 px-3 py-2 text-sm text-red-600 hover:bg-red-50"
                                        >
                                            Remove Image
                                        </button>
                                    </div>
                                @endif

                                <input
                                    id="{{ $key }}"
                                    type="file"
                                    name="{{ $key }}"
                                    accept="{{ $key === 'site_favicon' ? '.png,.ico,.jpg,.jpeg,.webp' : 'image/png,image/jpeg,image/webp' }}"
                                    class="block w-full rounded-xl border border-gray-300 p-3 text-sm"
                                >

                            @elseif($type === 'checkbox')
                                <input type="hidden" name="{{ $key }}" value="0">

                                <label class="flex items-center gap-3">
                                    <input
                                        id="{{ $key }}"
                                        type="checkbox"
                                        name="{{ $key }}"
                                        value="1"
                                        @checked(old($key, $settings[$key] ?? true))
                                        class="h-5 w-5 rounded border-gray-300"
                                    >
                                    <span class="text-sm text-gray-600">
                                        Enable indexing
                                    </span>
                                </label>

                            @elseif($type === 'color')
                                <div class="flex items-center gap-3">
                                    <input
                                        id="{{ $key }}"
                                        type="color"
                                        name="{{ $key }}"
                                        value="{{ old($key, $settings[$key] ?? '#000000') ?: '#000000' }}"
                                        class="h-11 w-16 cursor-pointer rounded-lg border border-gray-300 bg-white p-1"
                                    >
                                    <span class="text-sm text-gray-500">
                                        {{ $settings[$key] ?? '#000000' }}
                                    </span>
                                </div>

                            @else
                                <input
                                    id="{{ $key }}"
                                    type="{{ $type }}"
                                    name="{{ $key }}"
                                    value="{{ old($key, $settings[$key] ?? '') }}"
                                    class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900"
                                >
                            @endif
                        </div>
                    @endforeach

                    <div class="flex justify-end border-t border-gray-100 pt-6">
                        <button
                            type="submit"
                            class="rounded-xl bg-gray-900 px-6 py-3 text-sm font-semibold text-white transition hover:bg-gray-800"
                        >
                            Save Changes
                        </button>
                    </div>

                </form>

                {{-- Separate delete forms: never nest forms --}}
                @foreach($fields[$activeTab] as [$key, $label, $type])
                    @if($type === 'image' && !empty($settings[$key]))
                        <form
                            id="delete-{{ $key }}"
                            action="{{ route('settings.image.destroy', $key) }}"
                            method="POST"
                            class="hidden"
                        >
                            @csrf
                            @method('DELETE')
                        </form>
                    @endif
                @endforeach

            </div>
        </div>
    </div>
</div>
@endsection
