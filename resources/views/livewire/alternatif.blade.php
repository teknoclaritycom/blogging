<x-slot name="header">
    <h2 class="text-center">Tambah Alternatif</h2>
</x-slot>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
            @if (session()->has('message'))
            <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3"
                role="alert">
                <div class="flex">
                    <div>
                        <p class="text-sm">{{ session('message') }}</p>
                    </div>
                </div>
            </div>
            @endif
            <button wire:click="create()"
                class="my-4 inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-red-600 text-base font-bold text-white shadow-sm hover:bg-red-700">
                Tambah Alternatif
            </button>
            @if($isModalOpen)
            @include('livewire.createalt')
            @endif
            <table class="table-fixed w-full">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 w-20">Kode</th>
                        <th class="px-4 py-2">Nama Alternatif</th>
                        <th class="px-4 py-2">Jenis Tanah (K1)</th>
                        <th class="px-4 py-2">Curah Hujan (K2)</th>
                        <th class="px-4 py-2">Kelembaban Udara (K3)</th>
                        <th class="px-4 py-2">Ketinggian Tanah (K4)</th>
                        <th class="px-4 py-2">SUHU Minimum (K5)</th>
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($alternatif as $dcs)
                    <tr>
                        <td class="border px-4 py-2">{{ $dcs->kodetanaman }}</td>
                        <td class="border px-4 py-2">{{ $dcs->namatanaman }}</td>
                        @foreach ($dcs->kriteria as $item)
                        <td class="border px-4 py-2">{{ $item->pivot->score }}</td>
                        @endforeach
                        <td class="border px-4 py-2">
                            <button wire:click="edit({{ $dcs->id }})"
                                class="flex px-4 py-2 bg-gray-500 text-gray-900 cursor-pointer">Edit</button>
                            <button wire:click="delete({{ $dcs->id }})"
                                class="flex px-4 py-2 bg-red-100 text-gray-900 cursor-pointer">Hapus</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>