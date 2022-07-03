<div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
            role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <form>
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="">
                    <div class="mb-4">
                        <label for="exampleFormControlInput2"
                                class="block text-gray-700 text-sm font-bold mb-2">Silahkan Tentukan Tipe Kriteria untuk DMs</label>
                        </div>
                        <div class="mb-4">
                        <label for="exampleFormControlInput2"
                                class="block text-gray-700 text-sm font-bold mb-2">Jenis Tanah (C1):</label>
                            <select wire:model="c1">
                            <option value="">Silahkan Pilih</option>
                            <option value="benefit">Benefit</option>
                            <option value="cost">Cost</option>
                            </select>
                            @error('c1') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4">
                        <label for="exampleFormControlInput2"
                                class="block text-gray-700 text-sm font-bold mb-2">Curah Hujan (C2):</label>
                            <select wire:model="c2">
                            <option value="">Silahkan Pilih</option>
                            <option value="benefit">Benefit</option>
                            <option value="cost">Cost</option>
                            </select>
                            @error('c2') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4">
                        <label for="exampleFormControlInput2"
                                class="block text-gray-700 text-sm font-bold mb-2">Kelembaban Udara (C3):</label>
                            <select wire:model="c3">
                            <option value="">Silahkan Pilih</option>
                            <option value="benefit">Benefit</option>
                            <option value="cost">Cost</option>
                            </select>
                            @error('c3') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4">
                        <label for="exampleFormControlInput2"
                                class="block text-gray-700 text-sm font-bold mb-2">Ketinggian Lahan (C4):</label>
                            <select wire:model="c4">
                            <option value="">Silahkan Pilih</option>
                            <option value="benefit">Benefit</option>
                            <option value="cost">Cost</option>
                            </select>
                            @error('c4') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4">
                        <label for="exampleFormControlInput2"
                                class="block text-gray-700 text-sm font-bold mb-2">Suhu Udara Minimum (C5):</label>
                            <select wire:model="c5">
                            <option value="">Silahkan Pilih</option>
                            <option value="benefit">Benefit</option>
                            <option value="cost">Cost</option>
                            </select>
                            @error('c5') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4">
                            <label for="exampleFormControlInput2"
                                class="block text-gray-700 text-sm font-bold mb-2">Pilih DMs:</label>
                            <select wire:model="kodedms">
                            <option value="">Silahkan Pilih</option>
                                @foreach($decisioner as $pts)
                                <option value="{{$pts->kode}}">{{$pts->kode}}</option>
                                @endforeach
                            </select>
                            @error('kodedms') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                        <button wire:click.prevent="store()" type="button"
                            class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-red-600 text-base leading-6 font-bold text-white shadow-sm hover:bg-red-700 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                            Simpan
                        </button>
                    </span>
                    <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                        <button wire:click="closeModalPopover()" type="button"
                            class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-bold text-gray-700 shadow-sm hover:text-gray-700 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                            Tutup
                        </button>
                    </span>
                </div>
            </form>
        </div>
    </div>
</div>