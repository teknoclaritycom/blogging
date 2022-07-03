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
                            TAMBAH ALTERNATIF
                            <label for="exampleFormControlInput1"
                                class="block text-gray-700 text-sm font-bold mb-2">Kode</label>
                            <input type="text"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="exampleFormControlInput1" placeholder="Masukkan Kode Tanaman" wire:model="kodetanaman">
                            @error('kodetanaman') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4">
                            <label for="exampleFormControlInput2"
                                class="block text-gray-700 text-sm font-bold mb-2">Nama Alternatif:</label>
                            <textarea
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="exampleFormControlInput2" wire:model="namatanaman"
                                placeholder="Masukkan Nama Alternatif"></textarea>
                            @error('namatanaman') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4">
                            <label for="exampleFormControlInput2"
                                class="block text-gray-700 text-sm font-bold mb-2">Jenis Tanah:</label>
                            <select wire:model="kriteria.c1">
                                <option value="">Silahkan Pilih</option>
                                <option value="5">Andosol (5)</option>
                                <option value="4">Latosol (4)</option>
                                <option value="3">Organosol (3)</option>
                                <option value="2">Regosol (2)</option>
                                <option value="1">Podsol (1)</option>
                            </select>
                            @error('kriteria.c1') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4">
                            <label for="exampleFormControlInput2"
                                class="block text-gray-700 text-sm font-bold mb-2">Curah Hujan:</label>
                            <select wire:model="kriteria.c2">
                            <option value="">Silahkan Pilih</option>
                                <option value="1">>= 220cm (1)</option>
                                <option value="2">>=200cm (2)</option>
                                <option value="3">>=180cm (3)</option>
                                <option value="4">>140cm (4)</option>
                                <option value="5"><=140cm (5)</option>
                            </select>
                            @error('kriteria.c2') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4">
                            <label for="exampleFormControlInput2"
                                class="block text-gray-700 text-sm font-bold mb-2">Kelembaban Udara:</label>
                            <select wire:model="kriteria.c3">
                            <option value="">Silahkan Pilih</option>
                                <option value="1">>= 90% (1)</option>
                                <option value="2">>= 85% (2)</option>
                                <option value="3">>= 80% (3)</option>
                                <option value="4">> 70% (4)</option>
                                <option value="5"><= 70% (5)</option>
                            </select>
                            @error('kriteria.c3') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4">
                            <label for="exampleFormControlInput2"
                                class="block text-gray-700 text-sm font-bold mb-2">Ketinggian Lahan:</label>
                            <select wire:model="kriteria.c4">
                            <option value="">Silahkan Pilih</option>
                                <option value="5">>= 1000mdpl (5)</option>
                                <option value="4">>= 800mdpl (4)</option>
                                <option value="3">>= 600mdpl (3)</option>
                                <option value="2">> 400mdpl (2)</option>
                                <option value="1"><= 400mdpl (1)</option>
                            </select>
                            @error('kriteria.c4') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4">
                            <label for="exampleFormControlInput2"
                                class="block text-gray-700 text-sm font-bold mb-2">Suhu Minimum:</label>
                            <select wire:model="kriteria.c5">
                            <option value="">Silahkan Pilih</option>
                                <option value="5">>= 15deg (5)</option>
                                <option value="4">>= 17deg (4)</option>
                                <option value="3">>= 19deg (3)</option>
                                <option value="2">>= 21deg (2)</option>
                                <option value="1">>= 23deg (1)</option>
                            </select>
                            @error('kriteria.c5') <span class="text-red-500">{{ $message }}</span>@enderror
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