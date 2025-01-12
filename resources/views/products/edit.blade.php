<x-app-layout>
    <div class="p-6 flex flex-col gap-6 max-w-7xl mx-auto">
        <div class="">
            <h1 class="text-2xl font-semibold">
                Ubah
            </h1>
        </div>

        <div>

            <form id="productForm" action="{{ route('product.update', $product->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols gap-4">
                    <div class="flex gap-6 items-end w-full">
                        <div class="w-full">
                            <label for="category_id" class="block text-sm">Kategori</label>
                            <select name="category_id" id="category_id" class="block w-full p-3 rounded-md bg-white dark:bg-zinc-900 dark:text-white/70">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <!-- Modal toggle -->
                            <button data-modal-target="category-modal" data-modal-toggle="category-modal" class="bg-red-700 text-white px-4 py-1 hover:bg-red-500 rounded h-100 flex gap-2 items-center" type="button">
                                <i class='bx bx-plus font-bold'></i>
                                <span>
                                    Tambah
                                </span>
                            </button>
                        </div>
                    </div>

                    <div class="flex gap-6 items-end w-full">
                        <div class="w-full">
                            <label for="status_id" class="block text-sm">Status</label>
                            <select name="status_id" id="status_id" class="block w-full p-3 rounded-md bg-white dark:bg-zinc-900 dark:text-white/70">
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->id }}" {{ $status->id == $product->status_id ? 'selected' : '' }}>{{ Str::title($status->name) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <!-- Modal toggle -->
                            <button data-modal-target="status-modal" data-modal-toggle="status-modal" class="bg-red-700 text-white px-4 py-1 hover:bg-red-500 rounded h-100 flex gap-2 items-center" type="button">
                                <i class='bx bx-plus font-bold'></i>
                                <span>
                                    Tambah
                                </span>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label for="name" class="block text-sm">Nama</label>
                        <input type="text" name="name" id="name" value="{{ $product->name }}" class="w-full rounded-md p-3 bg-white dark:bg-zinc-900 dark:text-white/70 validate-input" placeholder="Masukan Nama" required/>
                    </div>
                    <div>
                        <label for="price" class="block text-sm">Harga</label>
                        <input type="number" min="0" name="price" id="price" value="{{ $product->price}}" class="w-full rounded-md p-3 bg-white dark:bg-zinc-900 dark:text-white/70 validate-input" placeholder="Masukan Harga" required step="1"/>
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="w-full text-white rounded-md p-3 bg-gray-900">Simpan</button>
                </div>
            </form>
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

    <div id="status-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Tambah Status
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
                    <form action="{{ route('status.store') }}" method="post">
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


    <x-slot name="footer">
        <script>
            const form = document.getElementById('productForm');
            const inputs = document.querySelectorAll('.validate-input');

            form.addEventListener('submit', function (e) {
                e.preventDefault();

                let isValid = true;

                inputs.forEach(input => {
                    if (input.value.trim() === '') {
                        input.classList.add('border-red-500');
                        input.classList.remove('border-green-500');
                        isValid = false;
                    } else {
                        input.classList.add('border-green-500');
                        input.classList.remove('border-red-500');
                    }
                });

                if (!isValid) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Harap isi semua data yang diperlukan!',
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses',
                        text: 'Data berhasil ditambahkan!',
                    }).then(() => {
                        form.submit(); // Kirim form ke server
                    });
                }
            });

            inputs.forEach(input => {
                input.addEventListener('input', () => {
                    if (input.value.trim() === '') {
                        input.classList.add('border-red-500');
                        input.classList.remove('border-green-500');
                    } else {
                        input.classList.add('border-green-500');
                        input.classList.remove('border-red-500');
                    }
                });
            });
        </script>
    </x-slot>
</x-app-layout>
