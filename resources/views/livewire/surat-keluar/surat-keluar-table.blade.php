<div wire:poll>
    {{-- @dd($data) --}}
    {{-- @dd($route) --}}
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
                    <th class="text-sm cursor-pointer" @click="$wire.sortField('tanggal_kirim_surat')">
                        <x-sort :$sortDirection :$sortBy :field="'tanggal_kirim_surat'" /> Tanggal Kirim Surat
                    </th>
                    <th class="text-sm cursor-pointer" @click="$wire.sortField('nomor_surat')">
                        <x-sort :$sortDirection :$sortBy :field="'nomor_surat'" /> Nomor Surat
                    </th>
                    <th class="text-sm cursor-pointer" @click="$wire.sortField('tanggal_surat')">
                        <x-sort :$sortDirection :$sortBy :field="'tanggal_surat'" /> Tanggal Surat
                    </th>
                    <th class="text-sm cursor-pointer" @click="$wire.sortField('tujuan_surat')">
                        <x-sort :$sortDirection :$sortBy :field="'tujuan_surat'" /> Tujuan Surat
                    </th>
                    <th class="text-sm cursor-pointer" @click="$wire.sortField('perihal_isi_surat')">
                        <x-sort :$sortDirection :$sortBy :field="'perihal_isi_surat'" /> Perihal Isi Surat
                    </th>
                    <th class="text-sm cursor-pointer" @click="$wire.sortField('keterangan')">
                        <x-sort :$sortDirection :$sortBy :field="'keterangan'" /> Keterangan
                    </th>
                    <th class="text-sm">Surat Masuk Yang Terkait</th>
                </tr>



                <tr>
                    {{-- <td></td> --}}
                    <td>
                        <span wire:loading.class="loading loading-spinner loading-xs text-white"></span>
                    </td>

                    <td>
                        <x-input wire:model="form.tanggal_kirim_surat" type="search" placeholder="Cari Tanggal Surat" class="w-full text-sm" />
                    </td>
                    <td>
                        <x-input wire:model="form.nomor_surat" type="search" placeholder="Cari Nomor Surat" class="w-full text-sm" />
                    </td>
                    <td>
                        <x-input wire:model="form.tanggal_surat" type="search" placeholder="Cari Tanggal Surat" class="w-full text-sm" />
                    </td>
                    <td>
                        <x-input wire:model="form.tujuan_surat" type="search" placeholder="Cari Tujuan Surat" class="w-full text-sm" />
                    </td>
                    <td>
                        <x-input wire:model="form.perihal_isi_surat" type="search" placeholder="Cari Perihal Isi Surat" class="w-full text-sm" />
                    </td>   

                    <td>
                        <x-input wire:model="form.keterangan" type="search" placeholder="Cari Keterangan" class="w-full text-sm" />
                    </td>


                </tr>


            </thead>

            <tbody>
                @forelse ($data as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td  class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_kirim_surat)->format('d-M-y') }}</td>
                        <td  class="text-center">{{ $item->nomor_surat }}</td>
                        <td  class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_surat)->format('d-M-y') }}</td>
                        <td  class="text-center">{{ $item->tujuan_surat }}</td>
                        <td  class="text-center">{{ $item->perihal_isi_surat }}</td>
                        <td  class="text-center">{{ $item->keterangan }}</td>
                        <td  class="text-center">{{ $item->suratMasuk->asal_surat_pengirim ?? "Tidak Ada Surat Masuk"}}</td>
                        <td class="text-center">
                            <x-button @click="$dispatch('dispatch-surat-keluar-table-edit', { id: '{{ $item->id }}' })"
                                type="button" class="text-sm">Detail</x-button>

                            @if (!$hideDeleteButton)

                                    <x-danger-button
                                        @click="$dispatch('dispatch-surat-keluar-table-delete', { id: '{{ $item->id }}', isi : '{{ $item->perihal_isi_surat }}' })">
                                        Delete</x-danger-button>

                                @endif
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">Tidak ada Data</td>
                    </tr>
                @endforelse
            </tbody>


        </table>
    </div>

    <div class="mt-3">
        {{ $data->onEachSide(1)->links() }}
    </div>
</div>
