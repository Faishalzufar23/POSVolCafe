<x-filament-panels::page class="!max-w-none">
    <div class="max-w-6xl mx-auto">
        {{ $this->form }}

        <div class="mt-6">
            <x-filament::button wire:click="save">
                Simpan Perubahan
            </x-filament::button>
        </div>
    </div>
</x-filament-panels::page>
