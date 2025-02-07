<div>
    <x-modal-file id="uploadModal" maxWidth="lg" wire:model.live="showModal"  submit="uploadFile">
        <x-slot name="title">
            Upload File PDF
        </x-slot>

        <x-slot name="content">
            <input type="file" wire:model="file" class="border p-2 w-full">
            @error('file') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </x-slot>

        <x-slot name="footer">
            <button type="submit" class="px-4 py-2 bg-blue-800 text-white rounded">Simpan</button>
            <button type="button" wire:click="$set('showModal', false)" class="ml-2 px-4 py-2 bg-gray-700 text-white rounded">Batal</button>
        </x-slot>
    </x-modal-file>
</div>