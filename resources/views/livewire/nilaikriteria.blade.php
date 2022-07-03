<x-slot name="header">
    <h2 class="text-center">Tambah Penilaian</h2>
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
                Tambah Penilaian
            </button>
            @if($isModalOpen)
            @include('livewire.createperbandingan')
            @endif
            <table class="table-fixed w-full">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2">Nama</th>
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($decisioner as $dcs)
                    <tr>
                        <td class="border px-4 py-2">{{ $dcs->nama}}</td>
                        <td class="border px-4 py-2">
                            <a wire:click="lihat({{ $dcs->id }})"
                                class="flex px-4 py-2 bg-gray-500 text-gray-900 cursor-pointer">Lihat Penilaian</a>
                        </td>                        
                    </tr>
                    @endforeach                    
                </tbody>
            </table>
            @if($isModalOpen1)
                            @include('livewire.lihatperbandingan')
                        @endif
        </div>
    </div>
</div>