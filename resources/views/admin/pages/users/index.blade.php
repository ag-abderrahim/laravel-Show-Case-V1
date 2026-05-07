@extends('admin.layout.app')

@section('title', 'Users')

@section('content')

@can('show users')

<div class="bg-white rounded-3xl shadow-sm border border-zinc-200 overflow-hidden">

    <!-- HEADER -->
    <div class="flex items-center justify-between px-8 py-6 border-b border-zinc-200">

        <div>
            <h2 class="text-2xl font-bold text-black">
                Users Management
            </h2>

            <p class="text-sm text-zinc-500 mt-1">
                Manage all application users
            </p>
        </div>

        @can('create user')
        <button onclick="openCreateModal()"
                class="bg-black text-white px-5 py-3 rounded-2xl font-medium hover:opacity-90 transition">

            + Add User

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
                        User
                    </th>

                    <th class="text-left px-8 py-4 text-sm font-semibold text-zinc-600">
                        Email Verification
                    </th>

                    <th class="text-left px-8 py-4 text-sm font-semibold text-zinc-600">
                        Status
                    </th>

                    <th class="text-right px-8 py-4 text-sm font-semibold text-zinc-600">
                        Actions
                    </th>

                </tr>

            </thead>

            <tbody class="divide-y divide-zinc-100">

                @forelse ($users as $user)

                <tr class="hover:bg-zinc-50 transition">

                    <td class="px-8 py-5 font-medium text-zinc-700">
                        #{{ $user->id }}
                    </td>

                    <!-- USER -->
                    <td class="px-8 py-5">

                        <div class="flex items-center gap-4">

                            <div class="w-11 h-11 rounded-2xl bg-black text-white flex items-center justify-center font-bold">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>

                            <div>

                                <p class="font-semibold text-black">
                                    {{ $user->name }}
                                </p>

                                <p class="text-sm text-zinc-500">
                                    {{ $user->email }}
                                </p>

                            </div>

                        </div>

                    </td>

                    <!-- EMAIL VERIFIED -->
                    <td class="px-8 py-5">

                        <form action="{{ route('users.verify', $user) }}"
                              method="POST">

                            @csrf
                            @method('PUT')

                            <label class="inline-flex items-center cursor-pointer">

                                <input type="checkbox"
                                       class="sr-only peer"
                                       onchange="this.form.submit()"
                                       {{ $user->email_verified ? 'checked' : '' }}>

                                <div class="relative w-12 h-6 bg-zinc-300 peer-focus:outline-none rounded-full peer peer-checked:bg-black transition-all">

                                    <span class="absolute top-0.5 left-0.5 bg-white w-5 h-5 rounded-full transition-all peer-checked:translate-x-6"></span>

                                </div>

                            </label>

                        </form>

                    </td>

                    <!-- ACTIVE -->
                    <td class="px-8 py-5">
                        <form action="{{ route('users.active', $user) }}"
                              method="POST">

                            @csrf
                            @method('PUT')

                            <label class="inline-flex items-center cursor-pointer">

                                <input type="checkbox"
                                       class="sr-only peer"
                                       onchange="this.form.submit()"
                                       {{ $user->is_active ? 'checked' : '' }}>

                                <div class="relative w-12 h-6 bg-zinc-300 peer-focus:outline-none rounded-full peer peer-checked:bg-black transition-all">

                                    <span class="absolute top-0.5 left-0.5 bg-white w-5 h-5 rounded-full transition-all peer-checked:translate-x-6"></span>

                                </div>

                            </label>

                        </form>

                    </td>

                    <!-- ACTIONS -->
                    <td class="px-8 py-5">

                        <div class="flex justify-end gap-3">

                            {{-- EDIT --}}
                            @can('edit user')
                            <button onclick="openEditModal({{ $user->id }})"
                                    class="px-4 py-2 rounded-xl bg-black text-white text-sm font-medium hover:opacity-90 transition">

                                Edit

                            </button>
                            @endcan

                            {{-- DELETE --}}
                            @can('delete user')
                            <form action="{{ route('users.destroy', $user) }}"
                                  method="POST"
                                  onsubmit="return confirm('Delete this user?')">

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

                    <td colspan="5" class="text-center py-16">

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
                                          d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>

                                </svg>

                            </div>

                            <h3 class="text-lg font-semibold text-black">
                                No users found
                            </h3>

                            <p class="text-zinc-500 text-sm mt-1">
                                Start by creating your first user
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
@can('create user')
<div id="createModal"
     class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-5">

    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-hidden flex flex-col">

        <!-- Header -->
        <div class="flex items-center justify-between px-8 py-6 border-b border-zinc-200">

            <div>
                <h3 class="text-xl font-bold">
                    Create User
                </h3>

                <p class="text-sm text-zinc-500 mt-1">
                    Add a new user to the system
                </p>
            </div>

            <button onclick="closeCreateModal()"
                    class="w-10 h-10 rounded-xl hover:bg-zinc-100 transition">

                ✕

            </button>

        </div>

        <!-- Body -->
        <div class="p-8 overflow-y-auto">

            @include('admin.pages.users.create')

        </div>

    </div>

</div>
@endcan


{{-- EDIT MODAL --}}
@can('edit user')
<div id="editModal"
     class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-5">

    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-hidden flex flex-col">

        <!-- Header -->
        <div class="flex items-center justify-between px-8 py-6 border-b border-zinc-200">

            <div>
                <h3 class="text-xl font-bold">
                    Edit User
                </h3>

                <p class="text-sm text-zinc-500 mt-1">
                    Update user information
                </p>
            </div>

            <button onclick="closeEditModal()"
                    class="w-10 h-10 rounded-xl hover:bg-zinc-100 transition">

                ✕

            </button>

        </div>

        <!-- Body -->
        <div class="p-8 overflow-y-auto" id="editModalContent">

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

        fetch('/admin/users/' + id + '/edit')
            .then(res => res.text())
            .then(data => {
                document.getElementById('editModalContent').innerHTML = data;
            });
    }

    function closeEditModal() {
        editModal.classList.add('hidden');
        editModal.classList.remove('flex');
    }

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
