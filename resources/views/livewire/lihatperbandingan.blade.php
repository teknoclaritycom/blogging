<div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
            role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="">
                    <div class="mb-4">
                        <table>
                            <thead style="background-color: #b3d7ff;">
                                <tr>
                                <td>Kriteria</td>
                                    @foreach ($data as $item)
                                    <td>
                                    {{ $item->nama }}
                                </td>
                                @endforeach
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($matriks as $key => $item)
                            <tr class="border">
                                <td style="background-color: #b3d7ff;"> {{ $data[$key]->nama }} </td>
                                @foreach ($item as $colum)
                                <td>{{ $colum }}</td>
                                @endforeach
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                        <button wire:click="closeModalPopover1()" type="button"
                            class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-bold text-gray-700 shadow-sm hover:text-gray-700 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                            Tutup
                        </button>
                    </span>
                </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>