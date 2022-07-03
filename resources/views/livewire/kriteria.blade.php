<x-slot name="header">
    <h2 class="text-center">Halaman Penilaian Tipe Kriteria</h2>
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
            @if(auth()->user()->email == "muhirvanj@gmail.com")
            <span>INGAT HANYA 3 PENILAIAN KARENA PENELITIAN INI MENGGUNAKAN 3 DMs</span>
            <button wire:click="create()"
                class="my-4 inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-red-600 text-base font-bold text-white shadow-sm hover:bg-red-700">
                Tambah Penilaian
            </button>
            @endif
            @if($isModalOpen)
            @include('livewire.createcri')
            @endif
            <table class="table-fixed w-full">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 w-20">No</th>
                        <th class="px-4 py-2">Jenis Tanah (C1)</th>
                        <th class="px-4 py-2">Curah Hujan (C2)</th>
                        <th class="px-4 py-2">Kelembaban Udara (C3)</th>
                        <th class="px-4 py-2">Ketinggian Lahan(C4)</th>
                        <th class="px-4 py-2">Suhu Udara Min(C5)</th>
                        <th class="px-4 py-2">DMs</th>
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kriteria as $dcs)
                    <tr>
                        <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="border px-4 py-2">{{ $dcs->c1 }}</td>
                        <td class="border px-4 py-2">{{ $dcs->c2 }}</td>
                        <td class="border px-4 py-2">{{ $dcs->c3 }}</td>
                        <td class="border px-4 py-2">{{ $dcs->c4 }}</td>
                        <td class="border px-4 py-2">{{ $dcs->c5 }}</td>
                        <td class="border px-4 py-2">{{ $dcs->kodedms }}</td>
                        <td class="border px-4 py-2">
                            <button wire:click="edit({{ $dcs->id }})"
                                class="flex px-4 py-2 bg-gray-500 text-gray-900 cursor-pointer">Edit</button>
                                @if(auth()->user()->email == "muhirvanj@gmail.com")
                            <button wire:click="delete({{ $dcs->id }})"
                                class="flex px-4 py-2 bg-red-100 text-gray-900 cursor-pointer">Hapus</button>
                                @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>