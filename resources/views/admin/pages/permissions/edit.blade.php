<form action="{{ route('permissions.update', $permission) }}"
      method="POST"
      class="space-y-6">

    @csrf
    @method('PUT')

    <!-- INPUT -->
    <div>

        <label class="block text-sm font-semibold text-zinc-700 mb-3">
            Permission Name
        </label>

        <input type="text"
               name="name"
               value="{{ $permission->name }}"
               required
               placeholder="Enter permission name..."
               class="w-full rounded-2xl border border-zinc-300 px-5 py-4
                      focus:outline-none focus:ring-2 focus:ring-black
                      focus:border-black transition bg-white text-black">

    </div>

    <!-- SUBMIT -->
    <button type="submit"
            class="w-full bg-black text-white py-4 rounded-2xl
                   font-semibold hover:opacity-90 transition">

        Save Role

    </button>

</form>
