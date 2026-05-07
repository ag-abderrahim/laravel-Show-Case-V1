@extends('admin.layout.app')

@section('title', 'Dashboard')

@section('content')

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <div class="bg-white rounded-2xl shadow-sm p-6 border border-zinc-200">
        <h3 class="text-zinc-500 text-sm">Users</h3>
        <p class="text-3xl font-bold mt-2">{{ $users->count() }}</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm p-6 border border-zinc-200">
        <h3 class="text-zinc-500 text-sm">Roles</h3>
        <p class="text-3xl font-bold mt-2">{{ $roles->count() }}</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm p-6 border border-zinc-200">
        <h3 class="text-zinc-500 text-sm">Permissions</h3>
        <p class="text-3xl font-bold mt-2">{{ $permissions->count() }}</p>
    </div>

</div>

@endsection
