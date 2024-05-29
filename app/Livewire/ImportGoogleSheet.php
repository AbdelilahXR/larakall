<?php

namespace App\Livewire;

use Livewire\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Revolution\Google\Sheets\Facades\Sheets;
use Filament\Forms\Components\Repeater;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Placeholder;
use Illuminate\Support\HtmlString;
use Filament\Notifications\Notification;
use App\Models\GoogleSheet;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use App\Helpers\OrderHelper;
use App\Services\ImportGoogleSheetService;

class ImportGoogleSheet extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;


    public $columns = [];
    public $sheetId;
    public $sheetName;
    public $sheetRange;
    public $sheetData;
    public $db_columns;
    public $statistics = [
        'total' => 0,
        'inserted' => 0,
        'updated' => 0,
        'failed' => 0,
    ];
    public $importFinished = false;
    public $selectedRecord;
    public $editExistSheet = false;
    public $errors = [];

    protected $listeners = ['refreshComponent' => '$refresh'];

    
    public function mount($selectedRecord)
    {
        $this->selectedRecord = $selectedRecord;

        $this->db_columns = [
            'reference' => "",
            'client' => "",
            'phone' => "",
            'city' => "",
            'adress' => "",
            'information' => "",
            'tracking_code' => "",
            'product_name' => "",
            'product_variant' => "",
            'price' => "",
            'total_quantity' => "",
            'sku' => "",
        ];
        
        if ($selectedRecord->google_sheets_id != null) {
            $GoogleSheet = GoogleSheet::find($selectedRecord->google_sheets_id);
            $this->sheetId = $GoogleSheet->sheet_id;
            $this->sheetName = $GoogleSheet->sheet_name;
            $this->db_columns = json_decode($GoogleSheet->matched_columns, true);
        }

    }



    public function getSheetData()
    {
        
        $rows = Sheets::spreadsheet($this->sheetId)
                ->sheet($this->sheetName)
                ->get();

        $header = $rows->pull(0);

        $this->columns = array_combine($header, $header);
        asort($this->columns);
        
        $values = Sheets::collection(header: $header, rows: $rows);
        
        $this->sheetData = $values->toArray();

        $this->dispatch('refreshComponent');
    }

    public function import()
    {
       $importGoogle =  new ImportGoogleSheetService();

        $this->statistics = [
            'total' => 0,
            'inserted' => 0,
            'updated' => 0,
            'failed' => 0,
        ];

        $groupedOrders = array_reduce($this->sheetData, function ($result, $item) {
            $reference = $item[$this->db_columns['reference']];
            if (!isset($result[$reference])) {
                $result[$reference] = [];
            }
            $result[$reference][] = $item;
            return $result;
        }, []);
       
        foreach ($groupedOrders as $group => $groupedOrder) {
            
            $this->statistics['total']++;

            $importResult = $importGoogle->HandleImport($groupedOrder, $this->db_columns, $this->selectedRecord->id);

            if ($importResult['status'] == 'success') {
               ($importResult['type'] == 'insert')? $this->statistics['inserted']++ : $this->statistics['updated']++;            
            }
            if ($importResult['status'] == 'error') {
                $this->statistics['failed']++;
                $this->errors[] = $importResult['errors'];
            }
        }
        if ($this->editExistSheet == false AND $this->selectedRecord->google_sheets_id == null) {            
            $GoogleSheet = GoogleSheet::create([
                'sheet_id' => $this->sheetId,
                'sheet_name' => $this->sheetName,
                'matched_columns' => json_encode($this->db_columns),
                'last_fetch' => now(),
                'success_orders' => $this->statistics['inserted'] + $this->statistics['updated'],
            ]);

            $this->selectedRecord->google_sheets_id = $GoogleSheet->id;
            $this->selectedRecord->save();
        }
        else
        {
            $GoogleSheet = GoogleSheet::find($this->selectedRecord->google_sheets_id);
            $GoogleSheet->matched_columns = json_encode($this->db_columns);
            $GoogleSheet->sheet_id = $this->sheetId;
            $GoogleSheet->sheet_name = $this->sheetName;
            $GoogleSheet->last_fetch = now();
            $GoogleSheet->success_orders = $this->statistics['inserted'] + $this->statistics['updated'];
            $GoogleSheet->save();
        }

        Notification::make()
        ->title(__('all.success'))
        ->success()
        ->body(__('all.import_finished_message'))->send();

    }


    protected function getForms(): array
    {
        return [
            'form',
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make('setup_sheet')
                        ->label(__('all.setup_sheet'))
                        ->schema([
                            Placeholder::make('total')
                            ->label(false)
                            ->content(new HtmlString('
                            
                            <div role="alert">
                            
                            <div class="bg-red-500 font-bold rounded-t px-4 py-2">
                                <b>How to connect Sheet With platform:</b>
                            </div>
                            <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                                <ol>
                                <li>- Copy This email: 
                                    <div style="border: 1px solid;
                                                width: fit-content;
                                                padding: 2px 10px;
                                                border-radius: 10px;
                                                margin: 10px auto;
                                                margin-bottom: 14px;">
                                                kall-center@sheet-417014.iam.gserviceaccount.com
                                    </div>
                                </li>
                                <li>- Go to your google sheet and share it with the email you just copied</li>
                                <li>- Click on the share button and select the email you just shared the sheet with</li>
                                <li>- Click on the pencil icon and select the role "Editor"</li>
                                <li>- Click on the "Advanced" button and select "Change" in the "Who can access" section</li>
                                <li>- Select "On - Anyone with the link" and click on "Save"</li>                            </div>
                                </ol>
                            </div>
                            
                            
                            '))
                        ]),
                    Wizard\Step::make('sheet_informations')
                        ->label(__('all.sheet_informations'))
                        ->schema([
                            TextInput::make('sheetId')
                                ->label(__('all.spread_sheet_id'))
                                ->placeholder('1BxiMVs0XRA5nFMdKvBdBZjgmUUqptlbs74OgvE2upms')
                                ->required(),
                            TextInput::make('sheetName')
                                ->label(__('all.sheet_name'))
                                ->placeholder('Sheet1')
                                ->required(),
                        ])->afterValidation(function () {
                            $this->getSheetData();
                        }),
                    Wizard\Step::make('columns_matching')
                        ->label(__('all.columns_matching'))
                        ->schema([
                            Select::make('db_columns.reference')->label('Reference')->options($this->columns)->required()->inlineLabel(),
                            Select::make('db_columns.client')->label('Client')->options($this->columns)->required()->inlineLabel(),
                            Select::make('db_columns.phone')->label('Phone')->options($this->columns)->required()->inlineLabel(),
                            Select::make('db_columns.city')->label('City')->options($this->columns)->required()->inlineLabel(),
                            Select::make('db_columns.adress')->label('Address')->options($this->columns)->inlineLabel(),
                            Select::make('db_columns.product_name')->label('Product Name')->options($this->columns)->required()->inlineLabel(),
                            Select::make('db_columns.product_variant')->label('Product Variant')->options($this->columns)->inlineLabel(),
                            Select::make('db_columns.price')->label('Price')->options($this->columns)->required()->inlineLabel(),
                            Select::make('db_columns.total_quantity')->label('Total Quantity')->options($this->columns)->required()->inlineLabel(),
                            Select::make('db_columns.sku')->label('SKU')->options($this->columns)->inlineLabel(),
                            Select::make('db_columns.tracking_code')->label('Tracking code')->options($this->columns)->inlineLabel(),
                            Select::make('db_columns.information')->label('Information')->options($this->columns)->inlineLabel(),
                            ])
                        ->afterValidation(function () {
                            $this->import();
                            $this->importFinished = true;
                        }),
                       
                    Wizard\Step::make('success')
                        ->label(__('all.success'))
                        ->schema([
                        ])
                    ])->submitAction(new HtmlString('<button type="submit">Import</button>')),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(GoogleSheet::query()->where('id', $this->selectedRecord->google_sheets_id))
            ->headerActions([
                Action::make('edit_sheet')
                    ->label(__('all.edit_sheet'))
                    ->icon('heroicon-o-pencil-square')
                    ->button()
                    ->color('primary')
                    ->action(function () { 
                        $this->editExistSheet = true;
                    }),
            ])
            ->columns([
                TextColumn::make('sheet_id')
                    ->label(__('all.sheet_id'))
                    ->limit(15)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                
                        if (strlen($state) <= $column->getCharacterLimit()) {
                            return null;
                        }
                        
                        return $state;
                    }),
                TextColumn::make('sheet_name')
                    ->label(__('all.sheet_name')),
                TextColumn::make('last_fetch')
                    ->label(__('all.last_fetch')),
                TextColumn::make('success_orders')
                    ->label(__('all.success_orders')),
            ])
            ->actions([
                Action::make('fetch_data')
                    ->label(__('all.fetch_new_orders'))
                    ->icon('heroicon-o-arrow-path')
                    ->button()
                    ->color('success')
                    ->action(function () { 
                        $this->getSheetData(); 
                        $this->import(); 
                        $this->importFinished = true;
                    }),
            ]);
    }


    public function render()
    {
        return view('livewire.import-google-sheet');
    }
}
