<x-app-layout>

    <div class="p-6 flex flex-col gap-6 max-w-7xl mx-auto">
        <div class="flex justify-between">
            <h1 class="text-2xl font-semibold">
                Pengaturan
            </h1>

            <div class="flex gap-2">
                <!-- Modal toggle -->
                <button data-modal-target="status-modal" data-modal-toggle="status-modal" class="bg-red-700 text-white px-4 py-1 hover:bg-red-500 rounded h-100 flex gap-2 items-center" type="button">
                    <i class='bx bx-plus font-bold'></i>
                    <span>
                        Reset
                    </span>
                </button>

                <a href="https://recruitment.fastprint.co.id/tes/api_tes_programmer" target="_blank" rel="noopener noreferrer" class="bg-red-700 text-white px-4 py-1 hover:bg-red-500 rounded h-100 flex gap-2 items-center">
                    <i class='bx bx-plus font-bold'></i>
                    <span>
                        Periksa API
                    </span>
                </a>
            </div>
        </div>

        <div class="p-4 bg-gray-100 rounded-md shadow-md">
            <form method="GET" action="{{ route('setting.index') }}" class="flex flex-col gap-4 md:flex-row md:items-end">
                {{-- Pencarian --}}
                <div class="flex flex-col flex-grow">
                    <label for="search" class="mb-1 text-sm font-medium text-gray-700">Pencarian</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                        placeholder="Cari..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" />
                </div>

                {{-- Tombol Cari --}}
                <div class="flex">
                    <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded-md shadow hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <i class="bx bx-search"></i> Cari
                    </button>
                </div>
            </form>
        </div>

        <div class="flex flex-col gap-6">
            @foreach ($histories as $history)
                <div class="bg-gray-100 border my-4 p-4 rounded-lg shadow-[0px 14px 34px 0px rgba(0,0,0,0.08)] dark:bg-zinc-900 dark:text-white/70 flex justify-between gap-6">
                    <div>
                        <h1 class="text-xl font-semibold">{{ $history->username }}</h1>
                        <p>Password : {{ $history->password }}</p>
                        <p>Password MD5 : {{ $history->password_md5 }}</p>
                        <p class="text-xs mt-2">
                            {{ \Carbon\Carbon::parse($history->created_at)->diffForHumans() }}
                        </p>
                    </div>

                    <div>
                        <div class="flex gap-2">
                            <a href="{{ route('setting.download', [$history->id]) }}" class="bg-gray-900 text-white px-4 py-1 hover:bg-gray-700 rounded">Download JSON</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $histories->links() }}
        </div>

    </div>

    <!-- Main modal -->
    <div id="status-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Tambah Status Baru
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="status-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4">
                    <form action="{{ route('setting.store') }}" method="post">
                        @csrf
                        @method('POST')

                        <div class="grid grid-cols gap-4 w-100">
                            <div>
                                <label for="username" class="block text-sm">Username</label>
                                <input type="text" name="username" id="username" class="w-full rounded-md p-3 bg-white dark:bg-zinc-900 dark:text-white/70" placeholder="Masukan Username"/>
                            </div>
                            <div>
                                <label for="password" class="block text-sm">Password</label>
                                <input type="text" name="password" id="password" class="w-full rounded-md p-3 bg-white dark:bg-zinc-900 dark:text-white/70" placeholder="Masukan Password"/>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end gap-2">
                            <button data-modal-hide="status-modal" type="submit" class="bg-gray-900 text-white px-4 py-1 hover:bg-gray-700 rounded">Simpan</button>

                            <button data-modal-hide="status-modal" type="button" class="bg-gray-700 text-white px-4 py-1 hover:bg-gray-500 rounded">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
