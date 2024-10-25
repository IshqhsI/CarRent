<x-app-layout>
    <x-slot name="title">Admin</x-slot>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            <a href="#!" onclick="window.history.go(-1); return false;">
                ←
            </a>
            {!! __('Item &raquo; Sunting &raquo; #') . $item->id . ' &middot; ' . $item->name !!}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div>
                @if ($errors->any())
                    <div class="mb-5" role="alert">
                        <div class="px-4 py-2 font-bold text-white bg-red-500 rounded-t">
                            Ada kesalahan!
                        </div>
                        <div class="px-4 py-3 text-red-700 bg-red-100 border border-t-0 border-red-400 rounded-b">
                            <p>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            </p>
                        </div>
                    </div>
                @endif

                {{-- Form --}}
                <form class="w-full" action="{{ route('admin.item.update', $item->id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="flex flex-wrap px-3 mt-4 mb-6 -mx-3">
                        <div class="w-full">
                            <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase"
                                for="name">
                                Nama*
                            </label>
                            <input value="{{ old('name') ?? $item->name }}" name="name"
                                class="block w-full px-4 py-3 leading-tight text-gray-700 bg-gray-200 border border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-gray-500"
                                id="name" type="text" placeholder="Nama" required>
                            <div class="mt-2 text-sm text-gray-500">
                                Nama item. Contoh: Item 1, Item 2, Item 3, dsb. Wajib diisi. Maksimal 255 karakter.
                            </div>
                        </div>
                    </div>

                    {{-- Tipe Select --}}
                    <div class="flex flex-wrap px-3 mt-4 mb-6 -mx-3">
                        <div class="w-full">
                            <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase"
                                for="type">
                                Tipe*
                            </label>
                            <select name="type_id" id="type"
                                class="block w-full px-4 py-3 leading-tight text-gray-700 bg-gray-200 border border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-gray-500">
                                <option value="">-- Pilih Tipe --</option>
                                @foreach ($types as $type)
                                    <option value="{{ $type->id }}"
                                        {{ (old('type_id') == $type->id || $item->type_id == $type->id) ? 'selected' : '' }}>{{ $type->name }}</option>
                                @endforeach
                            </select>
                            <div class="mt-2 text-sm text-gray-500">
                                Pilih Tipe item. Wajib diisi.
                            </div>
                        </div>
                    </div>

                    {{-- Brand Select --}}
                    <div class="flex flex-wrap px-3 mt-4 mb-6 -mx-3">
                        <div class="w-full">
                            <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase"
                                for="brand">
                                Brand*
                            </label>
                            <select name="brand_id" id="brand"
                                class="block w-full px-4 py-3 leading-tight text-gray-700 bg-gray-200 border border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-gray-500">
                                <option value="">-- Pilih Brand --</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}"
                                        {{ (old('brand_id') == $brand->id || $item->brand_id == $brand->id) ? 'selected' : '' }}>{{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="mt-2 text-sm text-gray-500">
                                Pilih Brand item. Wajib diisi.
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap px-3 mt-4 mb-6 -mx-3">
                        <div class="w-full">
                            <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase"
                                for="features">
                                Fitur*
                            </label>
                            <input value="{{ old('features') ?? $item->features }}" name="features"
                                class="block w-full px-4 py-3 leading-tight text-gray-700 bg-gray-200 border border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-gray-500"
                                id="features" type="text" placeholder="Fitur" required>
                            <div class="mt-2 text-sm text-gray-500">
                                Fitur item. Contoh: Fitur 1, Fitur 2, Fitur 3, dsb. Dipisahkan dengan koma (,). Opsional
                            </div>
                        </div>
                    </div>

                    {{-- images multiple, boleh lebih dari 1, opsional --}}
                    <div class="flex flex-wrap px-3 mt-4 mb-6 -mx-3">
                        <div class="w-full">
                            <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase"
                                for="images">
                                Gambar*
                            </label>
                            <input name="images[]" multiple value="{{ old('images') }}"
                                class="block w-full px-4 py-3 leading-tight text-gray-700 bg-gray-200 border border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-gray-500"
                                id="images" accept="image/*" type="file">
                            <div class="mt-2 text-sm text-gray-500">
                                Foto item. Lebih dari satu foto dapat diupload. Opsional
                            </div>
                        </div>
                    </div>

                    <div class="grid lg:grid-cols-3 gap-4 px-3 mt-4 mb-6 -mx-3">
                        <div class="w-full">
                            <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase"
                                for="price">
                                Harga
                            </label>
                            <input value="{{ old('price') ?? $item->price }}" name="price"
                                class="block w-full px-4 py-3 leading-tight text-gray-700 bg-gray-200 border border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-gray-500"
                                id="price" type="number" placeholder="Harga" required>
                            <div class="mt-2 text-sm text-gray-500">
                                Harga item. Angka. Contoh: 1000000. Wajib diisi.
                            </div>
                        </div>
                        <div class="w-full">
                            <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase"
                                for="rating">
                                Rating
                            </label>
                            <input value="{{ old('stars')  ?? $item->stars }}" name="stars"
                                class="block w-full px-4 py-3 leading-tight text-gray-700 bg-gray-200 border border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-gray-500"
                                id="rating" type="number" placeholder="Rating" min="1" max="5"
                                step=".01">
                            <div class="mt-2 text-sm text-gray-500">
                                Rating item. Angka. Contoh: 5. Opsional. Minimal 1, maksimal 5. Opsional
                            </div>
                        </div>
                        <div class="w-full">
                            <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase"
                                for="total-review">
                                Total Review
                            </label>
                            <input value="{{ old('reviews') ?? $item->reviews }}" name="reviews"
                                class="block w-full px-4 py-3 leading-tight text-gray-700 bg-gray-200 border border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-gray-500"
                                id="total-review" type="number" placeholder="Total Review">
                            <div class="mt-2 text-sm text-gray-500">
                                Total Review item. Angka. Opsional
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap mb-6 -mx-3">
                        <div class="w-full px-3 text-right">
                            <button type="submit"
                                class="px-4 py-2 font-bold text-white bg-green-500 rounded shadow-lg hover:bg-green-700">
                                Simpan Item
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
