<form action="{{ route('users.update', $user) }}"
      method="POST"
      class="space-y-6">

    @csrf
    @method('PUT')

    <!-- NAME -->
    <div>

        <label class="block text-sm font-semibold text-zinc-700 mb-3">
            Full Name
        </label>

        <input type="text"
               name="name"
               value="{{ $user->name }}"
               required
               placeholder="Enter full name..."
               class="w-full rounded-2xl border border-zinc-300 px-5 py-4
                      focus:outline-none focus:ring-2 focus:ring-black
                      focus:border-black transition bg-white text-black">

    </div>

    <!-- EMAIL -->
    <div>

        <label class="block text-sm font-semibold text-zinc-700 mb-3">
            Email Address
        </label>

        <input type="email"
               name="email"
               value="{{ $user->email }}"
               required
               placeholder="Enter email address..."
               class="w-full rounded-2xl border border-zinc-300 px-5 py-4
                      focus:outline-none focus:ring-2 focus:ring-black
                      focus:border-black transition bg-white text-black">

    </div>

    <!-- ROLE -->
    <div>

        <label class="block text-sm font-semibold text-zinc-700 mb-3">
            User Role
        </label>

        <select name="role"
                id="role"
                class="w-full rounded-2xl border border-zinc-300 px-5 py-4
                       focus:outline-none focus:ring-2 focus:ring-black
                       focus:border-black transition bg-white text-black">

            @foreach($roles as $role)

                <option value="{{ $role->id }}"
                    {{ $user->roles->contains($role->id) ? 'selected' : '' }}>

                    {{ ucfirst($role->name) }}

                </option>

            @endforeach

        </select>

    </div>

    <!-- SUBMIT -->
    <button type="submit"
            class="w-full bg-black text-white py-4 rounded-2xl
                   font-semibold hover:opacity-90 transition">

        Update User

    </button>

</form>
