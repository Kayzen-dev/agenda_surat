<div>

    <x-dialog-modal wire:model.live="modalSuratKeluarDelete" > 
        <x-slot name="title">
            Hapus data surat
        </x-slot>
    
        <x-slot name="content">
            <p>Apakah anda ingin menghapus data surat dengan ID: {{ $id }} dan dengan nomor surat : {{ $nomor_surat }}</p>

        </x-slot>
    
        <x-slot name="footer">
            <x-secondary-button @click="$wire.set('modalSuratKeluarDelete', false)" wire:loading.attr="disabled">
               Batal
            </x-secondary-button>
    
            <x-danger-button  @click="$wire.del()" class="ms-3" wire:loading.attr="disabled">
                Delete
            </x-danger-button>

        </x-slot>
    </x-dialog-modal>

</div>
