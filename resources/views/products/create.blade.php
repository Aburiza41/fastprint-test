<x-app-layout>
    <div class="p-6 flex flex-col gap-6 max-w-7xl mx-auto">
        <div class="">
            <h1 class="text-2xl font-semibold">
                Tambah
            </h1>
        </div>

        <div>

            <form action="{{ route('product.store') }}" method="POST">
                @csrf
                @method('POST')

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="category_id" class="block text-sm">Kategori</label>
                        <select id="category_id" name="category_id" class="block w-full p-3 rounded-md bg-white dark:bg-zinc-900 dark:text-white/70">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="status_id" class="block text-sm">Status</label>
                        <select id="status_id" name="status_id" class="block w-full p-3 rounded-md bg-white dark:bg-zinc-900 dark:text-white/70">
                            @foreach ($statuses as $status)
                                <option value="{{ $status->id }}">{{ Str::title($status->name) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="name" class="block text-sm">Nama</label>
                        <input type="text" name="name" id="name" class="w-full rounded-md p-3 bg-white dark:bg-zinc-900 dark:text-white/70" />
                    </div>
                    <div>
                        <label for="price" class="block text-sm">Harga</label>
                        <input type="number" min="0" name="price" id="price" class="w-full rounded-md p-3 bg-white dark:bg-zinc-900 dark:text-white/70" />
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="w-full bg-#FF2D20 text-white rounded-md p-3 bg-gray-900">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
