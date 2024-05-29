<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\StateOrder;

class StatesHistory extends Component
{
    public $data;


    public function mount($selectedRecord)
    {
        // get name of state using $selectedRecord->id
        $selectedRecord = StateOrder::with(['state', 'user'])->where('orders_id', $selectedRecord->id)->orderBy('created_at', 'Asc')->get();

        // filter data to get only state name and user name and date 
        $selectedRecord = $selectedRecord->map(function ($item) {
            return [
                'state' => $item->state->name,
                'user' => $item->user->name,
                'date' => $item->created_at,
                'color' => $item->state->color
            ];
        });

        $this->data = $selectedRecord;
    }


    public function render()
    {
        return view('livewire.states-history');
    }
}
