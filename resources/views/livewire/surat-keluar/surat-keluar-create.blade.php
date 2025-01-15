<div x-data="suratMasukRealtime()" x-init="init()">

    @if ($hideButton)
    <x-secondary-button @click="$wire.set('modalSuratKeluarCreate', true)">
        Tambah Surat Keluar
    </x-secondary-button>
    @endif



    <a href="{{ route('export.surat.keluar',['bidang_surat' => $bidang_surat]) }}" class="btn btn-sm inline-flex items-center px-4 py-2 bg-gray-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150">
        EXPORT EXCEL
    </a>

    <a href="{{ route('export-surat-pdf',['bidang_surat' => $bidang_surat, 'tipe_surat' => 'surat-keluar']) }}" class="btn btn-sm inline-flex items-center px-4 py-2 bg-gray-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150">
        EXPORT PDF
    </a>

    <x-dialog-surat-masuk wire:model="modalSuratKeluarCreate" :id="'modal-surat-keluar-create'" submit="save">
        <x-slot name="title">
            Tambah Surat Keluar
        </x-slot>

        <x-slot name="content">
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label for="kategori_surat" class="label dark:text-grey">Kategori Surat Keluar</label>
                            <select wire:model="form.kategori_surat" id="kategori_surat" required class="select select-bordered w-full">
                                <option value="">-- Pilih Kategori Surat Keluar --</option>
                                <option value="Surat Perintah">Surat Perintah</option>
                                <option value="Surat Tugas">Surat Tugas</option>
                                <option value="Surat Perjalanan Dinas">Surat Perjalanan Dinas</option>
                                <option value="Disposisi">Disposisi</option>
                                <option value="Nota Dinas">Nota Dinas</option>
                                <option value="Surat Dinas">Surat Dinas</option>
                                <option value="Surat Kuasa">Surat Kuasa</option>
                                <option value="Berita Acara">Berita Acara</option>
                                <option value="Surat Keterangan">Surat Keterangan</option>
                                <option value="Telaahan Staf">Telaahan Staf</option>
                                <option value="Pengumuman">Pengumuman</option>
                                <option value="Surat Pernyataan Melaksanakan Tugas">Surat Pernyataan Melaksanakan Tugas</option>
                                <option value="Surat Panggilan">Surat Panggilan</option>
                                <option value="Surat Izin">Surat Izin</option>
                                <option value="Surat Perjanjian">Surat Perjanjian</option>
                                <option value="Rekomendasi">Rekomendasi</option>
                                <option value="Sertifikat">Sertifikat</option>
                                <option value="Piagam">Piagam</option>
                            </select>
      
                            <x-input-form-error for="form.kategori_surat" class="mt-1" />
      
                    </div>




                <!-- Tanggal Surat -->
                <div>
                    <label for="tanggal_surat" class="label dark:text-grey">Tanggal Surat</label>
                    <input wire:model="form.tanggal_surat" type="date" id="tanggal_surat" required class="input input-bordered w-full">
                    <x-input-form-error for="form.tanggal_surat" class="mt-1" />
                </div>

                <!-- Tanggal Kirim Surat -->
                <div>
                    <label for="tanggal_kirim_surat" class="label dark:text-grey">Tanggal Kirim Surat</label>
                    <input wire:model="form.tanggal_kirim_surat" type="date" id="tanggal_kirim_surat" required class="input input-bordered w-full">
                    <x-input-form-error for="form.tanggal_kirim_surat" class="mt-1" />
                </div>


            </div>

            <div class="grid grid-cols-2 gap-4">
                <!-- Pilih Surat Masuk -->
                <div>
                    <label for="id_surat_masuk" class="label dark:text-grey">Balas Surat Masuk</label>
                    <select wire:model.defer="form.id_surat_masuk" id="id_surat_masuk" class="select select-bordered w-full">
                        <option value="">Pilih Surat Masuk</option>
                        <template x-for="surat in suratMasukList" :key="surat.id">
                            <option :value="surat.id" x-text="`${surat.nomor_surat} - ${surat.asal_surat_pengirim}`"></option>
                        </template>
                    </select>
                    <x-input-form-error for="form.id_surat_masuk" class="mt-1" />
                </div>


                <!-- Nomor Surat -->
                <div>
                    <label for="nomor_surat" class="label dark:text-grey">Nomor Surat</label>
                    <input wire:model="form.nomor_surat" type="text" id="nomor_surat" class="input input-bordered w-full" required placeholder="Masukkan Nomor Surat">
                    <x-input-form-error for="form.nomor_surat" class="mt-1" />
                </div>


            </div>

            <div class="grid grid-cols-2 gap-4">
                <!-- Tujuan Surat -->
                <div>
                    <label for="tujuan_surat" class="label dark:text-grey">Tujuan Surat</label>
                    <textarea wire:model="form.tujuan_surat" id="tujuan_surat" class="textarea textarea-bordered w-full" required placeholder="Masukkan Tujuan Surat"></textarea>
                    <x-input-form-error for="form.tujuan_surat" class="mt-1" />
                </div>

                <!-- Perihal Isi Surat -->
                <div>
                    <label for="perihal_isi_surat" class="label dark:text-grey">Perihal Isi Surat</label>
                    <textarea wire:model="form.perihal_isi_surat" id="perihal_isi_surat" class="textarea textarea-bordered w-full" required placeholder="Masukkan Perihal/Isi Surat"></textarea>
                    <x-input-form-error for="form.perihal_isi_surat" class="mt-1" />
                </div>
            </div>

            <div>
                <!-- Keterangan -->
                <label for="keterangan" class="label dark:text-grey">Keterangan Surat Keluar</label>
                <textarea wire:model="form.keterangan" id="keterangan" class="textarea textarea-bordered w-full" required placeholder="Masukkan Keterangan "></textarea>
                <x-input-form-error for="form.keterangan" class="mt-1" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button @click="$wire.set('modalSuratKeluarCreate', false)">
                Batal
            </x-secondary-button>

                    <x-btn-accent type="submit" class="ms-3 btn-accent">
                        Simpan
                    </x-btn-accent>
        </x-slot>


    </x-dialog-surat-masuk>


    <script>
        function suratMasukRealtime() {
            return {
                suratMasukList: [],
                fetchSuratMasukList() {
                    fetch('/surat-masuk')
                        .then((response) => response.json())
                        .then((data) => {
                            this.suratMasukList = data;
                        })
                        .catch((error) => {
                            console.error('Gagal memuat daftar surat masuk:', error);
                        });
                },
                init() {
                    this.fetchSuratMasukList();

                    setInterval(() => {
                        this.fetchSuratMasukList();
                    }, 3000);
                },
            };
        }

    </script>
</div>
