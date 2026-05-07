@extends('admin.layout.app')

@section('title', 'Permissions')

@section('content')

@can('show roles')

<div class="bg-white rounded-3xl shadow-sm border border-zinc-200 overflow-hidden">

    <!-- HEADER -->
    <div class="flex items-center justify-between px-8 py-6 border-b border-zinc-200">

        <div>
            <h2 class="text-2xl font-bold text-black">
                Permissions Management
            </h2>

            <p class="text-sm text-zinc-500 mt-1">
                Manage all application permissions
            </p>
        </div>

        @can('create role')
        <button onclick="openCreateModal()"
                class="bg-black text-white px-5 py-3 rounded-2xl font-medium hover:opacity-90 transition">

            + Add Permission
        </button>
        @endcan

    </div>

    <!-- TABLE -->
    <div class="overflow-x-auto">

        <table id="aTable" class="w-full">

            <thead class="bg-zinc-50 border-b border-zinc-200">

                <tr>

                    <th class="text-left px-8 py-4 text-sm font-semibold text-zinc-600">
                        ID
                    </th>

                    <th class="text-left px-8 py-4 text-sm font-semibold text-zinc-600">
                        Permission Name
                    </th>

                    <th class="text-right px-8 py-4 text-sm font-semibold text-zinc-600">
                        Actions
                    </th>

                </tr>

            </thead>

            <tbody class="divide-y divide-zinc-100">

                @forelse ($permissions as $permission)

                <tr class="hover:bg-zinc-50 transition">

                    <td class="px-8 py-5 font-medium text-zinc-700">
                        #{{ $permission->id }}
                    </td>

                    <td class="px-8 py-5">

                        <div class="flex items-center gap-3">

                            <div class="w-10 h-10 rounded-2xl bg-black text-white flex items-center justify-center font-bold">
                                {{ strtoupper(substr($permission->name, 0, 1)) }}
                            </div>

                            <div>
                                <p class="font-semibold text-black">
                                    {{ $permission->name }}
                                </p>

                                <p class="text-xs text-zinc-500">
                                    System permission
                                </p>
                            </div>

                        </div>

                    </td>

                    <td class="px-8 py-5">

                        <div class="flex justify-end gap-3">

                            {{-- EDIT --}}
                            @can('edit permission')
                            <button onclick="openEditModal({{ $permission->id }})"
                                    class="px-4 py-2 rounded-xl bg-black text-white text-sm font-medium hover:opacity-90 transition">

                                Edit
                            </button>
                            @endcan

                            {{-- DELETE --}}
                            @can('delete role')
                            <form action="{{ route('permissions.destroy', $permission) }}"
                                  method="POST"
                                  onsubmit="return confirm('Delete this role?')">

                                @csrf
                                @method('DELETE')

                                <button class="px-4 py-2 rounded-xl border border-red-200 text-red-600 text-sm font-medium hover:bg-red-50 transition">

                                    Delete
                                </button>

                            </form>
                            @endcan

                        </div>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="3" class="text-center py-16">

                        <div class="flex flex-col items-center">

                            <div class="w-16 h-16 rounded-full bg-zinc-100 flex items-center justify-center mb-4">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="w-8 h-8 text-zinc-400"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>

                                </svg>

                            </div>

                            <h3 class="text-lg font-semibold text-black">
                                No roles found
                            </h3>

                            <p class="text-zinc-500 text-sm mt-1">
                                Start by creating your first role
                            </p>

                        </div>

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endcan


{{-- CREATE MODAL --}}
@can('create permission')
<div id="createModal"
     class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-5">

    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl overflow-hidden">

        <!-- Header -->
        <div class="flex items-center justify-between px-8 py-6 border-b border-zinc-200">

            <div>
                <h3 class="text-xl font-bold">
                    Create Permission
                </h3>

                <p class="text-sm text-zinc-500 mt-1">
                    Add a new permission to the system
                </p>
            </div>

            <button onclick="closeCreateModal()"
                    class="w-10 h-10 rounded-xl hover:bg-zinc-100 transition">

                ✕

            </button>

        </div>

        <!-- Body -->
        <div class="p-8 overflow-y-auto">

            @include('admin.pages.permissions.create')

        </div>

    </div>

</div>
@endcan


{{-- EDIT MODAL --}}
@can('edit permission')
<div id="editModal"
     class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-5">

    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-hidden flex flex-col">

        <!-- Header -->
        <div class="flex items-center justify-between px-8 py-6 border-b border-zinc-200">

            <div>
                <h3 class="text-xl font-bold">
                    Edit Permission
                </h3>

                <p class="text-sm text-zinc-500 mt-1">
                    Update permission information
                </p>
            </div>

            <button onclick="closeEditModal()"
                    class="w-10 h-10 rounded-xl hover:bg-zinc-100 transition">

                ✕

            </button>

        </div>

        <!-- Body -->
        <div class="p-8" id="editModalContent">

        </div>

    </div>

</div>
@endcan


<script>

    // =========================
    // CREATE MODAL
    // =========================

    const createModal = document.getElementById('createModal');

    function openCreateModal() {
        createModal.classList.remove('hidden');
        createModal.classList.add('flex');
    }

    function closeCreateModal() {
        createModal.classList.add('hidden');
        createModal.classList.remove('flex');
    }

    // Close when clicking outside
    createModal.addEventListener('click', function (e) {

        if (e.target === createModal) {
            closeCreateModal();
        }

    });


    // =========================
    // EDIT MODAL
    // =========================

    const editModal = document.getElementById('editModal');

    function openEditModal(id) {

        editModal.classList.remove('hidden');
        editModal.classList.add('flex');

        fetch('/admin/permissions/' + id + '/edit')
            .then(res => res.text())
            .then(data => {
                document.getElementById('editModalContent').innerHTML = data;
            });
    }

    function closeEditModal() {
        editModal.classList.add('hidden');
        editModal.classList.remove('flex');
    }

    // Close when clicking outside
    editModal.addEventListener('click', function (e) {

        if (e.target === editModal) {
            closeEditModal();
        }

    });


    // =========================
    // ESC KEY CLOSE
    // =========================

    document.addEventListener('keydown', function (e) {

        if (e.key === 'Escape') {

            closeCreateModal();
            closeEditModal();

        }

    });

</script>

@endsection
