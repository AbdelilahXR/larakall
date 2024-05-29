<div>
    @if (!$this->importFinished)
        @if ($this->selectedRecord->google_sheets_id == null OR $this->editExistSheet)
            {{ $this->form }}
        @else
            {{ $this->table }}
        @endif
    @endif

    @if ($this->importFinished)
        <x-filament::section icon="heroicon-s-document-chart-bar" icon-color="success">
            <x-slot name="heading">
                {{ __('all.statistics') }}
            </x-slot>

            <div style="color: #155724; background-color: #d4edda; border-color: #c3e6cb;position: relative; padding: .75rem 1.25rem; margin-bottom: 1rem; border: 1px solid transparent; border-radius: .25rem;">
                {{ __('all.import_finished_message') }}
            </div>
            <livewire:import-result-overview :data="$this->statistics" />
        </x-filament::section>

    
        @if (!empty($this->errors))
        <x-filament::section icon="heroicon-s-x-circle" style="margin-top: 20px" icon-color="danger">
            <x-slot name="heading">
                {{ __('all.errors') }}
            </x-slot>
            @foreach ($this->errors as $error)
            <div class="flex" style="color: #721c24; background-color: #f8d7da; border-color: #f5c6cb;position: relative; padding: .75rem 1.25rem; margin-bottom: 1rem; border: 1px solid transparent; border-radius: .25rem;">
                <div style="width:10%; text-align: center">
                    <div class="">
                        {{ __('all.order') }}
                    </div>
                    <div style="font-size: 20px; font-weight: bold">
                        {{ $error['order'] }}
                    </div>
                </div>
                <div style="width:90%">
                    <ul>
                        @foreach ($error['error'] as $error)
                            <li> ⚠ {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endforeach
        </x-filament::section>
    @endif

    @endif
</div>


