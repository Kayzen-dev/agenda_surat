<div x-data="suratKeluarRealtime()" x-init="init()">

    @if ($hideButton)
    <x-secondary-button @click="$wire.set('modalSuratKeluarCreate', true)">
        Tambah Surat Keluar
    </x-secondary-button>

    <form class="flex justify-end">
        <div class="w-full max-w-xs mr-3">
            <label for="export" class="label dark:text-grey">Export Excel Surat Keluar</label>
            <select wire:model="kategori_surat" wire:change="exportExcel" id="export" class="select select-bordered w-full max-w-xs border-gray-100 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                <option selected value="null">Pilih Kategori Surat Keluar</option>
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
        
        </div>
        <div class="w-full max-w-xs">
            <label for="export" class="label dark:text-grey">Export Pdf Surat Keluar</label>
            <select wire:model="kategori_surat_pdf" wire:change="exportPdf" id="export" class="select select-bordered w-full max-w-xs border-gray-100 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                <option selected value="null">Pilih Kategori Surat Keluar</option>
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
        
        </div>
    </form>
    
    @endif




      

    <x-dialog-surat-masuk wire:model="modalSuratKeluarCreate" :id="'modal-surat-keluar-create'" submit="save">
        <x-slot name="title">
            Tambah Surat Keluar
        </x-slot>

        <x-slot name="content">

            <div class="grid grid-cols-2 gap-4" >
                <div>
                    <label for="kategori">Pilih Kategori Surat Keluar :</label>
                    <select id="kategori"  wire:model="form.kategori_surat" x-model="selectedKategori" @change="fetchSuratKeluarList()" class="select select-bordered w-full">
                        <option selected value="">-- Pilih Kategori --</option>
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
            
                <div>
                    <label for="tanggal">Pilih Tanggal:</label>
                    <input type="date" id="tanggal"  wire:model="form.tanggal_surat" x-model="selectedTanggalRaw" @change="updateFormattedDate()" class="input input-bordered w-full">
                </div>
            

            </div>


            <div class="grid grid-cols-1 gap-6 mt-6"> 
                <Label>Nomor Surat </Label>
                <div class="flex items-center space-x-2">
                    {{-- <input type="text" wire:model="form.kode_akses"   class="input text-gray-200 p-2 rounded-l-md w-50" placeholder="Kode Hak akses" aria-label="Kode"> <!-- Mengatur lebar input agar serasi --> --}}
                    <select wire:model="form.kode_akses" class="select select-bordered p-2 rounded-md w-50">
                        <option selected value="">-- Pilih Kode Hak Akses --</option>
                        <option value="B">B</option>
                        <option value="T">T</option>
                        <option value="R">R</option>
                        <option value="SR">SR</option>
                    </select>
                    
                    <span class="text-black text-2xl">/</span>
              
                    <input type="text"  wire:model="form.kode_klasifikasi" class="input text-gray-200 p-2 rounded-md w-50" placeholder="Kode klasifikasi" aria-label="Kode"> <!-- Mengatur lebar input agar serasi -->
                    
              
                    
                    <span class="text-black text-2xl">/</span>
              

                    <!-- Select No Urut -->
                    <select id="surat" wire:model="form.no" class="select select-bordered p-2 rounded-md w-50">
                        <option selected value="">-- Pilih No urut --</option>
                        <template x-for="surat in suratKeluarList" :key="surat.no">
                            <option :value="surat.no" x-text="surat.nomor_surat !== '-' ? `${surat.no} - ${surat.nomor_surat}` : `${surat.no} - no urut tersedia`"></option>
                        </template>
                    </select>


              
                    
                    <span class="text-black text-2xl">/</span>
              
                    {{-- <input type="text"  wire:model="form.nama_instansi" class="input text-gray-200 p-2 rounded-md w-50" placeholder="Nama Instansi/Bidang" oninput="this.value = this.value.toUpperCase()" aria-label="Nama Bidang/Instansi"> --}}
                    <select wire:model="form.nama_instansi" class="select select-bordered p-2 rounded-md w-50">
                        <option selected value="">-- Pilih Instansi/Bidang --</option>
                        <Option value="{{ ucwords($bidang_surat) }}">{{ ucwords($bidang_surat) }}</Option>
                        <option value="DISPUSIP">DISPUSIP</option>
                        {{-- <option value="Kearsipan">Kearsipan</option>
                        <option value="Pengembangan">Pengembangan</option>
                        <option value="Layanan">Layanan</option>
                        <option value="Sekretariat">Sekretariat</option> --}}
                    </select>
                    
                    <span class="text-black text-2xl">/</span>
              
                    <input type="number"  wire:model="form.tahun" class="input text-gray-200 p-2 rounded-r-md w-50" placeholder="Tahun" aria-label="Tahun">

                </div>
            </div>

            <div class="flex justify-start gap-6 mt-6">
                <x-input-form-error for="form.kode_akses" class="m-2" />
                <x-input-form-error for="form.kode_klasifikasi" class="m-2" />
                <x-input-form-error for="form.no" class="m-2" />
                <x-input-form-error for="form.nama_instansi" class="m-2" />
                <x-input-form-error for="form.tahun" class="m-2" />
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
        document.addEventListener("DOMContentLoaded", function () {
            const inputField = document.querySelector("input[wire\\:model='form.kode_klasifikasi']");
            
            if (inputField) {
                inputField.addEventListener("input", function (event) {
                    this.value = this.value.replace(/[^0-9.]/g, "").replace(/\s+/g, "");
                });
            }
        });

        function suratKeluarRealtime() {
            return {
                selectedKategori: '',
                selectedTanggalRaw: new Date().toISOString().split('T')[0], // Default: Hari ini (format YYYY-MM-DD)
                selectedTanggalFormatted: '', // Format "04 Februari 2035"
                suratKeluarList: [],

                // Fungsi untuk mengubah tanggal ke format "04 Februari 2035"
                updateFormattedDate() {
                    const dateObj = new Date(this.selectedTanggalRaw);
                    const formatter = new Intl.DateTimeFormat('id-ID', { day: '2-digit', month: 'long', year: 'numeric' });
                    this.selectedTanggalFormatted = formatter.format(dateObj);
                    this.fetchSuratKeluarList();
                },

                // Fungsi mengambil data surat keluar
                fetchSuratKeluarList() {
                    if (!this.selectedKategori || !this.selectedTanggalFormatted) return;

                    fetch(`/surat-keluar/${encodeURIComponent(this.selectedKategori)}/${encodeURIComponent(this.selectedTanggalFormatted)}`)
                        .then(response => response.json())
                        .then(data => {
                            this.suratKeluarList = data;
                        })
                        .catch(error => {
                            console.error('Gagal memuat daftar surat keluar:', error);
                        });
                },

                init() {
                    this.updateFormattedDate();
                    setInterval(() => {
                        this.fetchSuratKeluarList();
                    }, 3000); // Cek setiap 3 detik
                }

            };
        }
    </script>
</div>
