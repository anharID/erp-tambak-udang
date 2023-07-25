<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Terimakasih sudah mendaftar! Sebelum mulai, bisakah anda memverifikasi alamat email anda dengan menekan link yang baru saja kami kirimkan pada email anda? Jika anda tidak menerima link tersebut, kami akan dengan senang hati mengirimkan link baru kepada anda.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
            {{ __('Link verifikasi baru telah dikirimkan ke alamat email yang anda berikan pada pendaftaran.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    {{ __('Kirim ulang email verifikasi') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                {{ __('Keluar') }}
            </button>
        </form>
    </div>
</x-guest-layout>
