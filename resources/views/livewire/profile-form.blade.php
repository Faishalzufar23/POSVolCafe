<div class="fi-bg-base fi-text-base p-6 rounded-xl border fi-border-base shadow">

    <h2 class="text-xl font-bold mb-6">Informasi Profil</h2>

    @if (session()->has('success'))
        <div class="mb-4 text-green-600 font-medium">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-2 gap-6">

        <div>
            <label class="block text-sm mb-1">Nama</label>
            <input
                type="text"
                wire:model="name"
                class="w-full border fi-border-base fi-bg-base fi-text-base rounded p-2"
            >
        </div>

        <div>
            <label class="block text-sm mb-1">Email</label>
            <input
                type="email"
                wire:model="email"
                class="w-full border fi-border-base fi-bg-base fi-text-base rounded p-2"
            >
        </div>

        <div class="col-span-2">
            <label class="block text-sm mb-1">Password Baru</label>
            <input
                type="password"
                wire:model="password"
                class="w-full border fi-border-base fi-bg-base fi-text-base rounded p-2"
                placeholder="Kosongkan jika tidak ingin mengganti"
            >
        </div>

    </div>

    <div class="mt-6">
        <x-filament::button wire:click="save">
            Simpan Perubahan
        </x-filament::button>
    </div>

</div>
