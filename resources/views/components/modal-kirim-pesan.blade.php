@props(['id' => null, 'maxWidth' => null, 'submit' => null])

<x-modal-form  :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    @if ($submit) <form wire:submit="{{ $submit }}"> @endif
    
         <div class="px-6 py-4">
        <div class="text-lg font-medium text-gray-900">
            {{ $title }}
        </div>

        <div class="mt-4 text-sm text-gray-600">
            {{ $content }}
        </div>
    </div>

    <div class="flex flex-row justify-end px-6 py-4 text-end">
        {{ $footer }}
    </div>
    @if ($submit) </form> @endif

</x-modal-form>
