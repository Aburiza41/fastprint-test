<x-app-layout>

    <div class="p-6 flex flex-col gap-6 max-w-7xl mx-auto">
        <div class="flex justify-between">
            <h1 class="text-2xl font-semibold">
                Semua Kategori
            </h1>

            <!-- Modal toggle -->
            <button data-modal-target="category-modal" data-modal-toggle="category-modal" class="bg-red-700 text-white px-4 py-1 hover:bg-red-500 rounded h-100 flex gap-2 items-center" type="button">
                <i class='bx bx-plus font-bold'></i>
                <span>
                    Tambah
                </span>
            </button>
        </div>

        <div class="p-4 bg-gray-100 rounded-md shadow-md">
            <form method="GET" action="{{ route('category.index') }}" class="flex flex-col gap-4 md:flex-row md:items-end">
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
            @foreach ($categories as $category)
                <div class="bg-gray-100 border my-4 p-4 rounded-lg shadow-[0px 14px 34px 0px rgba(0,0,0,0.08)] dark:bg-zinc-900 dark:text-white/70 flex justify-between gap-6">
                    <div>
                        <h1 class="text-xl font-semibold">{{ $category->name }}</h1>
                        <p>Total Data Produk Terkait : {{ $category->products->count() }} Produk</p>
                    </div>

                    <div>
                        <div class="flex gap-2">
                            {{-- <a href="{{ route('category.edit', [$category->id]) }}" class="bg-gray-900 text-white px-4 py-1 hover:bg-gray-700 rounded">Ubah</a> --}}

                            <button data-modal-target="edit-modal{{ $category->id }}" data-modal-toggle="edit-modal{{ $category->id }}" class="bg-gray-900 text-white px-4 py-1 hover:bg-gray-700 rounded" type="button">
                                Ubah
                            </button>

                            <div id="edit-modal{{ $category->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-full max-w-2xl max-h-full">
                                    <!-- Modal content -->
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <!-- Modal header -->
                                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                Ubah Data Kategori {{ $category->name }}
                                            </h3>

                                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="edit-modal{{ $category->id }}">
                                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                        </div>

                                        <!-- Modal body -->
                                        <div class="p-4 md:p-5 space-y-4">

                                            <form action="{{ route('category.update', [$category->id]) }}" method="post">
                                                @csrf
                                                @method('PUT')

                                                <div class="flex flex-col gap-4 w-100">
                                                    <div>
                                                        <label for="name" class="block text-sm">Nama</label>
                                                        <input type="text" name="name" id="name" class="w-full rounded-md p-3 bg-white dark:bg-zinc-900 dark:text-white/70" placeholder="Masukan Nama" value="{{ $category->name }}"/>
                                                    </div>
                                                </div>

                                                <div class="mt-6 flex justify-end gap-2">
                                                    <button data-modal-hide="edit-modal{{ $category->id }}" type="submit" class="bg-red-700 text-white px-4 py-1 hover:bg-red-500 rounded">Ya</button>

                                                    <button data-modal-hide="edit-modal{{ $category->id }}" type="button" class="bg-gray-700 text-white px-4 py-1 hover:bg-gray-500 rounded">Batal</button>
                                                </div>


                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal toggle -->
                            <button data-modal-target="default-modal{{ $category->id }}" data-modal-toggle="default-modal{{ $category->id }}" class="bg-red-700 text-white px-4 py-1 hover:bg-red-500 rounded" type="button">
                                Hapus
                            </button>

                            <!-- Main modal -->
                            <div id="default-modal{{ $category->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-full max-w-2xl max-h-full">
                                    <!-- Modal content -->
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <!-- Modal header -->
                                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                Anda Yakin Ingin Menghapus data ini?
                                            </h3>

                                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal{{ $category->id }}">
                                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                        </div>

                                        <!-- Modal body -->
                                        <div class="p-4 md:p-5 space-y-4">
                                            <div class="mb-4">
                                                <p>
                                                    Sistem akan menghapus semua produk terkait kategori ini
                                                </p>
                                            </div>
                                            <form action="{{ route('category.destroy', [$category->id]) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button data-modal-hide="default-modal{{ $category->id }}" type="submit" class="bg-red-700 text-white px-4 py-1 hover:bg-red-500 rounded">Ya</button>

                                                <button data-modal-hide="default-modal{{ $category->id }}" type="button" class="bg-gray-700 text-white px-4 py-1 hover:bg-gray-500 rounded">Batal</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $categories->links() }}
        </div>
    </div>

    <!-- Main modal -->
    <div id="category-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Tambah Kategori
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="category-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4">
                    <form action="{{ route('category.store') }}" method="post">
                        @csrf
                        @method('POST')

                        <div class="flex flex-col gap-4 w-100">
                            <div>
                                <label for="name" class="block text-sm">Nama</label>
                                <input type="text" name="name" id="name" class="w-full rounded-md p-3 bg-white dark:bg-zinc-900 dark:text-white/70" placeholder="Masukan Nama"/>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end gap-2">
                            <button data-modal-hide="category-modal" type="submit" class="bg-gray-900 text-white px-4 py-1 hover:bg-gray-700 rounded">Simpan</button>

                            <button data-modal-hide="category-modal" type="button" class="bg-gray-700 text-white px-4 py-1 hover:bg-gray-500 rounded">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
