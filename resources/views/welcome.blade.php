<x-app-layout>

    <div class="p-6 flex flex-col gap-6 max-w-7xl mx-auto">
        <div class="flex justify-between">
            <h1 class="text-2xl font-semibold">
                Produk Di Jual
            </h1>

            <a href="{{ route('product.create') }}" class="bg-gray-900 text-white px-4 py-1 hover:bg-gray-700 rounded">Tambah</a>
        </div>

        <div class="flex flex-col gap-6">
            @foreach ($products as $product)
                <div class="bg-gray-100 border my-4 p-4 rounded-lg shadow-[0px 14px 34px 0px rgba(0,0,0,0.08)] dark:bg-zinc-900 dark:text-white/70 flex justify-between gap-6">
                    <div>
                        <h1 class="text-xl font-semibold">{{ $product->name }}</h1>
                        <p class="text-xs mt-2"><span class="bg-gray-900 text-white py-0.5 px-2 rounded">{{ $product->category->name }}</span></p>
                        <p class="text-2xl mt-4 font-extrabold">Rp. {{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>

                    <div>
                        <div class="flex gap-2">
                            <a href="{{ route('product.edit', [$product->id]) }}" class="bg-gray-900 text-white px-4 py-1 hover:bg-gray-700 rounded">Ubah</a>

                            <!-- Modal toggle -->
                            <button data-modal-target="default-modal{{ $product->id }}" data-modal-toggle="default-modal{{ $product->id }}" class="bg-red-700 text-white px-4 py-1 hover:bg-red-500 rounded" type="button">
                                Hapus
                            </button>

                            <!-- Main modal -->
                            <div id="default-modal{{ $product->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-full max-w-2xl max-h-full">
                                    <!-- Modal content -->
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <!-- Modal header -->
                                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                Anda Yakin Ingin Menghapus data ini?
                                            </h3>
                                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal{{ $product->id }}">
                                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                        </div>

                                        <!-- Modal body -->
                                        <div class="p-4 md:p-5 space-y-4">
                                            <form action="{{ route('product.destroy', [$product->id]) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button data-modal-hide="default-modal{{ $product->id }}" type="submit" class="bg-red-700 text-white px-4 py-1 hover:bg-red-500 rounded">Ya</button>

                                                <button data-modal-hide="default-modal{{ $product->id }}" type="button" class="bg-gray-700 text-white px-4 py-1 hover:bg-gray-500 rounded">Batal</button>
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
            {{ $products->links() }}
        </div>
    </div>
</x-app-layout>
