@extends('admin.layout.app')

@section('title', 'Roles Permissions')

@section('content')

<div class="max-w-7xl mx-auto">

    <div class="bg-white rounded-3xl shadow-sm border border-zinc-200 overflow-hidden">

        <!-- HEADER -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 px-8 py-7 border-b border-zinc-200">

            <div>

                <h2 class="text-2xl font-bold text-black">
                    Manage Permissions
                </h2>

                <p class="text-sm text-zinc-500 mt-1">
                    Assign permissions to this role or
                    <a href="{{ route('roles.index') }}"
                       class="font-medium text-black hover:underline">
                        return
                    </a>
                </p>

            </div>

            <div class="inline-flex items-center gap-2 bg-black text-white px-5 py-3 rounded-2xl">

                <div class="w-3 h-3 rounded-full bg-green-400"></div>

                <span class="font-semibold">
                    {{ $role->name }}
                </span>

            </div>

        </div>

        <!-- FORM -->
        <form action="{{ route('addPermissions', $role->id) }}"
              method="POST"
              class="p-8 space-y-8">

            @csrf

            @foreach ($pers as $per)

                <div class="border border-zinc-200 rounded-3xl overflow-hidden">

                    <!-- GROUP HEADER -->
                    <div class="bg-zinc-50 border-b border-zinc-200 px-6 py-5 flex items-center justify-between">

                        <div>

                            <h3 class="text-lg font-semibold text-black">
                                {{ ucfirst($per->name) }} Permissions
                            </h3>

                            <p class="text-sm text-zinc-500 mt-1">
                                Manage all {{ strtolower($per->name) }} related permissions
                            </p>

                        </div>

                        <!-- TOGGLE -->
                        <button type="button"
                                onclick="toggleGroup('{{ $per->name }}')"
                                class="px-4 py-2 rounded-xl border border-zinc-300 text-sm font-medium hover:bg-zinc-100 transition">

                            Toggle All

                        </button>

                    </div>

                    <!-- PERMISSIONS -->
                    <div class="p-6">

                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">

                            @foreach ($permissions as $permission)

                                @if (stripos($permission->name, $per->name) !== false)

                                    <label class="group cursor-pointer">

                                        <input type="checkbox"
                                               class="hidden peer"
                                               name="permissions[{{ $per->name }}][]"
                                               value="{{ $permission->name }}"
                                               data-group="{{ $per->name }}"
                                               {{ $role->hasAnyPermission($permission->name) ? 'checked' : '' }}>

                                        <div class="border border-zinc-200 rounded-2xl p-5 transition-all duration-200
                                                    hover:border-black hover:shadow-sm
                                                    peer-checked:bg-black
                                                    peer-checked:text-white
                                                    peer-checked:border-black">

                                            <div class="flex items-start justify-between gap-4">

                                                <div>

                                                    <p class="font-semibold text-sm">
                                                        {{ $permission->name }}
                                                    </p>

                                                    <p class="text-xs mt-1 opacity-70">
                                                        Permission Access
                                                    </p>

                                                </div>

                                                <div class="w-6 h-6 rounded-full border-2 border-zinc-300 flex items-center justify-center
                                                            peer-checked:border-white">

                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         class="w-3.5 h-3.5 hidden peer-checked:block"
                                                         fill="none"
                                                         viewBox="0 0 24 24"
                                                         stroke="currentColor">

                                                        <path stroke-linecap="round"
                                                              stroke-linejoin="round"
                                                              stroke-width="3"
                                                              d="M5 13l4 4L19 7"/>

                                                    </svg>

                                                </div>

                                            </div>

                                        </div>

                                    </label>

                                @endif

                            @endforeach

                        </div>

                    </div>

                </div>

            @endforeach

            <!-- SUBMIT -->
            <div class="pt-4">

                <button type="submit"
                        class="w-full bg-black text-white py-4 rounded-2xl font-semibold text-lg hover:opacity-90 transition">

                    Save Permissions

                </button>

            </div>

        </form>

    </div>

</div>

<script>

function toggleGroup(groupName)
{
    const checkboxes = document.querySelectorAll(`[data-group="${groupName}"]`);

    const allChecked = Array.from(checkboxes).every(cb => cb.checked);

    checkboxes.forEach(cb => {
        cb.checked = !allChecked;
    });
}

</script>

@endsection
