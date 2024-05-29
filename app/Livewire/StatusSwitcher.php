<?php

namespace App\Livewire;

use App\Models\State;
use App\Models\StateOrder;
use App\Models\Order;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Support\Colors\Color;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class StatusSwitcher extends Component implements HasForms, HasInfolists
{
    use InteractsWithForms;
    use InteractsWithInfolists;

    public $record;
    public $type;
    public $status;
    public $created_at;

    public ?array $data = [];

    public function mount($selectedRecord, $type)
    {

        $this->record = $selectedRecord;

        $this->form->fill([
            'status_id' => self::getRecord($this->type)->id ?? null,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('status_id')
                    ->label(__('all.state'))
                    ->options(State::where('type', $this->type)->pluck('name', 'id')->toArray())
                    ->native(false)
                    ->required(),
            ])
            ->statePath('data');
    }

    public function productInfolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record(self::getRecord($this->type))
            ->schema([
                TextEntry::make('name')
                    ->icon('heroicon-o-arrow-path')
                    ->badge()
                    ->label(false)
                    ->color(Color::hex(self::getRecord($this->type)->color)),
            ]);
    }

    public function update(): void
    {
        $stateOrder = new StateOrder();
        $stateOrder->users_id = auth()->id();
        $stateOrder->states_id = $this->form->getState()['status_id'];
        $stateOrder->orders_id = $this->record->id;
        $stateOrder->created_at = now();

        $existingRecord = StateOrder::where('states_id', $stateOrder->states_id)
            ->where('orders_id', $stateOrder->orders_id)
            ->first();

        if (!$existingRecord) {
            $stateOrder->save();


            // update order state in confirmation_state or delivery_state
            $this->record->{$this->type . '_state'} = $stateOrder->states_id;
            $this->record->save();

            
            Notification::make()
                ->title(__('all.changed_successfully'))
                ->success()
                ->body(__('all.state_changed_successfully'))->send();

        } else {

            Notification::make()
                ->title(__('all.already_stated'))
                ->warning()
                ->body(__('all.this_state_is_already_used'))->send();
        }

        $this->dispatch('close-modal', id: 'switch-status');

    }

    protected function getRecord($type)
    {

        if ($type == 'confirmation') {
            $status = $this->record->lastConfirmationState;
            // get last confirmation state created_at in state_order

            $this->created_at = StateOrder::where('orders_id', $this->record->id)
                ->where('states_id', $status?->id)
                ->orderBy('created_at', 'desc')
                ->first()->created_at ?? null;

        } else {
            $status = $this->record->lastDeliveryState;
            $this->created_at = StateOrder::where('orders_id', $this->record->id)
                ->where('states_id', $status?->id)
                ->orderBy('created_at', 'desc')
                ->first()->created_at ?? null;
        }

        if (!$status) {
            $status = new State();
            $status->name = 'none';
            $status->color = '#1e168c';
        }

        return $status;
    }

    public function render()
    {
        return view('livewire.status-switcher');
    }
}
