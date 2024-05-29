<x-filament::modal  id="switch-status">
    <style>
        .button-state-changer .grid.gap-6{
            display:block;
        }
    </style>
    <x-slot name="heading">
        {{ __('all.change_status') }}
    </x-slot>
    
    <x-slot name="trigger" class="button-state-changer fi-ta-text grid w-full gap-y-1 px-3 py-4 text-center" style="display:block;padding-bottom: 4px">
        {{ $this->productInfolist }}
        <div style="font-size: 9px; margin-top: 5px">
            {{ $this->created_at }}
        </div>
    </x-slot>

    <form>
        {{ $this->form }}

        <x-filament::button wire:click="update" style="margin-top: 13px; float: right">
            update
        </x-filament::button>
    </form>
</x-filament::modal>
