<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Booking') }}
        </h2>
    </x-slot>

    <x-slot name="script">
        <script>
            let datatable = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{!! url()->current() !!}',
                },
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.12.1/i18n/id.json'
                },
                columns: [{
                        data: 'id',
                        name: 'id',
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'item.brand.name',
                        name: 'item.brand.name'
                    },
                    {
                        data: 'item.name',
                        name: 'item.name'
                    },
                    {
                        data: 'start_date',
                        name: 'start_date',
                        render: function(data) {
                            return moment(data).format('DD MMMM YYYY');
                        }
                    },
                    {
                        data: 'end_date',
                        name: 'end_date',
                        render: function(data) {
                            return moment(data).format('DD MMMM YYYY');
                        }
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'payment_status',
                        name: 'payment_status'
                    },
                    {
                        data: 'total_price',
                        name: 'total_price',
                        render: function(data) {
                            return new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                            }).format(data);
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        width: '15%'
                    },
                ],
            });
        </script>
    </x-slot>

    <div class="py-8 lg:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- <div class="mb-10">
                <a href="{{ route('admin.booking.create') }}"
                    class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">+
                    Tambah Booking</a>
            </div> --}}
            <div class="overflow-hidden shadow sm:rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <table id="dataTable">
                        <thead>
                            <tr>
                                <th style="max-width: 1%" class="text-left">ID</th>
                                <th class="text-left">Nama</th>
                                <th class="text-left">Brand</th>
                                <th class="text-left">Item</th>
                                <th class="text-left">Mulai</th>
                                <th class="text-left">Selesai</th>
                                <th class="text-left">Status Booking</th>
                                <th class="text-left">Status Pembayaran</th>
                                <th class="text-left">Total Harga</th>
                                <th class="text-left" style="max-width: 1%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
