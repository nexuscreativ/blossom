<x-filament-panels::page>
    <form wire:submit="save">
        {{ $this->form }}

        <div class="fi-section mt-6">
            <x-filament::button type="submit">
                Save Settings
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>