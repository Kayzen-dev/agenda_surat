<div wire:poll>
    {{-- @dd($data) --}}

    {{-- {{ $form->kategori_surat == ? dd($form) }} --}}
    {{-- @dd($p) --}}
    <label class="text-xs" for="jumlahSurat">Jumlah Data Yang Ditampilkan</label>
    <x-select wire:model="paginate" id="jumlahSurat" class="text-sm mt-8">
        <option value="3">3</option>
        <option value="5">5</option>
        <option value="10">10</option>
        <option value="25">25</option>
        <option value="50">50</option>
        <option value="100">100</option>
    </x-select>


    <div class="overflow-x-auto mt-4">
        <table class="table table-zebra">
            <!-- head -->
            <thead>
                <tr>
                    <th>No</th>
                    <th class="text-sm cursor-pointer" @click="$wire.sortField('kategori_surat')">
                        <x-sort :$sortDirection :$sortBy :field="'kategori_surat'" /> Kategori Surat
                    </th>

                    <th class="text-sm cursor-pointer" @click="$wire.sortField('tanggal_terima_surat')">
                        <x-sort :$sortDirection :$sortBy :field="'tanggal_terima_surat'" /> Tanggal <br> Terima Surat
                    </th>

                    <th class="text-sm cursor-pointer" @click="$wire.sortField('no_agenda')">
                        <x-sort :$sortDirection :$sortBy :field="'no_agenda'" /> No <br> Agenda
                    </th>
                    <th class="text-sm cursor-pointer" @click="$wire.sortField('nomor_surat')">
                        <x-sort :$sortDirection :$sortBy :field="'nomor_surat'" />  Nomor Surat
                    </th>
                    
                    <th class="text-sm cursor-pointer" @click="$wire.sortField('asal_surat_pengirim')">
                        <x-sort :$sortDirection :$sortBy :field="'asal_surat_pengirim'" /> Asal Surat / Pengirim
                    </th>


                </tr>
                <tr>
                    {{-- @dump($form) --}}

                    {{-- @php
                        var_dump($form);
                    @endphp --}}

                    <td>
                        <span wire:loading.class="loading loading-spinner loading-xs text-white"></span>
                    </td>

                    <td>
                        <x-input wire:model="form.kategori_surat" type="search" placeholder="Cari Kategori Surat" class="w-full text-sm" />
                    </td>
                    <td>
                        <x-input wire:model="form.tanggal_terima_surat" type="search" placeholder="Cari Tanggal Terima Surat" class="w-full text-sm" />
                    </td>
                    <td>
                        <x-input wire:model="form.no_agenda" type="search" placeholder="Cari No Agenda" class="w-full text-sm" />
                    </td>
                    <td>
                        <x-input wire:model="form.nomor_surat" type="search" placeholder="Cari Nomor Surat" class="w-full text-sm" />
                    </td>   

                    <td>
                        <x-input wire:model="form.asal_surat_pengirim" type="search" placeholder="Cari Asal Surat Pengirim" class="w-full text-sm" />
                    </td>

                </tr>
            </thead>

            <tbody>


                @forelse ($data as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td  class="text-center">{{ $item->kategori_surat }}</td>
                        <td  class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_terima_surat)->format('d-M-y') }}</td>
                        <td class="text-center">{{ $item->bidang_surat }}</td>
                        <td  class="text-center">{{ $item->nomor_surat }}</td>
                        <td  class="text-center text-sm">{{ $item->asal_surat_pengirim }}</td>
                        <td class="text-center">
                            <x-button @click="$dispatch('dispatch-surat-masuk-table-edit', { id: '{{ $item->id }}' })"
                                type="button" class="text-sm">Detail</x-button>


                            @if (!$hideDeleteButton)
                                <x-danger-button
                                    @click="$dispatch('dispatch-surat-masuk-table-delete', { id: '{{ $item->id }}', nomor_surat: '{{ $item->nomor_surat }}' })">
                                    Delete
                                </x-danger-button>
                            @endif

                            
                            @if($item->file_surat)
                                <button wire:click="downloadFile({{ $item->id }})" class="btn btn-success m-1">
                                    <i class="fas fa-download"></i> Unduh
                                </button>
                                @if (Auth::user()->hasRole($form->bidang_surat))
                                        <button class="btn btn-primary m-1"  @click="$dispatch('dispatch-surat-keluar-table-update', { id: '{{ $item->id }}', tipeSurat : 'surat-masuk' })">
                                            Ganti file
                                        </button>
                                @endif
                            @else
                                @if (Auth::user()->hasRole($form->bidang_surat))
                                    <button class="btn btn-primary m-1"  @click="$dispatch('dispatch-surat-keluar-table-upload', { id: '{{ $item->id }}', tipeSurat : 'surat-masuk' })">
                                        Upload
                                    </button>
                                @else
                                    <div class="badge badge-info">
                                        File Belum Di upload
                                    </div>
                                @endif
                            @endif

                            
                            
                            
                        </td>


                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada Data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $data->onEachSide(1)->links() }}
    </div>


</div>
