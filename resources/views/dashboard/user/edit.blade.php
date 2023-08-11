<x-admin>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-gray-900 dark:text-gray-100">
            <h1 class="mb-4 text-xl font-bold">Edit Akun Pengguna</h1>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 ">
                    <form method="POST" action="{{ route('users.update', $user->id) }}">
                        @method('put')
                        @csrf

                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                :value=" $user->name ?? old('name')" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Email Address -->
                        <div class="mt-4">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                :value="$user->email ?? old('email')" required autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        {{-- <div class="mt-4">
                            <x-input-label for="username" :value="__('Username')" />
                            <x-text-input id="username" class="block mt-1 w-full" type="text" name="username"
                                :value="old('username')" required autocomplete="username" />
                            <x-input-error :messages="$errors->get('username')" class="mt-2" />
                        </div> --}}

                        <div class="mt-4">
                            <x-input-label for="role" :value="__('Role')" />
                            <select name="role"
                                class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm px-4 py-2">
                                <option value="" disabled selected>Pilih satu opsi</option>
                                {{-- <option value="superadmin" {{ $user->role == 'superadmin' ? 'selected' : ''
                                    }}>Super
                                    Admin</option> --}}
                                <option value="direktur" {{ $user->role == 'direktur' ? 'selected' : '' }}>Direktur
                                </option>
                                <option value="manajer keuangan" {{ $user->role == 'manajer keuangan' ? 'selected' : ''
                                    }}>Manajer Keuangan</option>
                                <option value="teknisi" {{ $user->role == 'teknisi' ? 'selected' : '' }}>Teknisi
                                </option>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>

                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Ubah Akun') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

</x-admin>

{{-- <label for="name" class="block text-sm text-gray-700 dark:text-gray-400">Name </label>
<input type="text" name="name"
    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
    placeholder="Jane Doe" />
<label for="email" class="block mt-4 text-sm text-gray-700 dark:text-gray-400">Email </label>
<input type="email" name="email"
    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
    placeholder="Jane Doe" />

<label for="role" class="block mt-4 text-sm text-gray-700 dark:text-gray-400">Role</label>
<select name="role"
    class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-blue-400 focus:outline-none focus:shadow-outline-blue dark:focus:shadow-outline-gray">
    <option disabled selected>Pilih satu opsi</option>
    <option value="superadmin">Super Admin</option>
    <option value="direktur">Direktur</option>
    <option value="manajer keuangan">Manajer Keuangan</option>
    <option value="teknisi">Teknisi</option>
    <option value="admin">Admin</option>
</select> --}}