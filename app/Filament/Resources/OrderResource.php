<?php

namespace App\Filament\Resources;

use App\Filament\Exports\OrderExporter;
use App\Filament\Imports\OrderImporter;
use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\Widgets\OrderStats;
use App\Models\Export;
use App\Models\Order;
use App\Models\Store;
use App\Models\Product;
use App\Models\OrderProduct;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Set;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\OrderHelper;
use App\Livewire\TopNavBar;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?int $navigationSort = -2;

    // listner current store
    protected static $listeners = ['current_store'];

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->label(__('all.code'))
                    ->placeholder(__('all.add_code'))
                    ->default(OrderHelper::generateReference())
                    ->disabled()
                    ->dehydrated()
                    ->required()
                    ->maxLength(32)
                    ->unique(Order::class, 'code', ignoreRecord: true),
                Forms\Components\TextInput::make('reference')
                    ->placeholder(__('all.add_reference'))
                    ->label(__('all.reference'))
                    ->required()
                    ->maxLength(45)
                    ->unique(Order::class, 'reference', ignoreRecord: true),
                Forms\Components\TextInput::make('client')
                    ->label(__('all.client'))
                    ->placeholder(__('all.add_client'))
                    ->maxLength(45),
                Forms\Components\TextInput::make('phone')
                    ->label(__('all.phone'))
                    ->placeholder(__('all.add_phone'))
                    ->tel()
                    ->maxLength(45),
                Forms\Components\TextInput::make('price')
                    ->label(__('all.price'))
                    ->placeholder(__('all.add_price'))
                    ->numeric()
                    ->prefix('MAD'),
                Forms\Components\TextInput::make('city')
                    ->label(__('all.city'))
                    ->placeholder(__('all.add_city'))
                    ->maxLength(45),
                Forms\Components\Textarea::make('adress')
                    ->label(__('all.address'))
                    ->placeholder(__('all.add_address'))
                    ->maxLength(90)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('information')
                    ->label(__('all.information'))
                    ->placeholder(__('all.add_information'))
                    ->maxLength(45)
                    ->columnSpanFull(),

                Forms\Components\Section::make(__('all.products'))
                    ->columns(1)
                    ->schema([
                        Forms\Components\Repeater::make('products')
                            ->relationship()
                            ->schema([
                                Forms\Components\Select::make('products_id')
                                    ->label(__('all.product_name'))
                                    ->options(fn ($livewire) => Product::filterByUserStores()->where('stores_id', $form?->getRecord()?->stores_id ?? ($livewire->getTableFilterState('stores_id')['value']) ?? 0)->get()->pluck('fullName', 'id')->toArray())
                                    ->required()
                                    ->reactive()
                                    ->afterStateUpdated(fn($state, Forms\Set $set) => $set('unit_price', Product::find($state)?->max_price ?? 0))
                                    ->distinct()
                                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                    ->columnSpan([
                                        'md' => 5,
                                    ])
                                    ->searchable()
                                    ->HiddenOn('show'),

                                Forms\Components\Select::make('products_id')
                                    ->label(__('all.product_name'))
                                    ->options(fn ($livewire) => Product::filterByUserStores()->get()->pluck('fullName', 'id')->toArray())
                                    ->columnSpan([
                                        'md' => 5,
                                    ])
                                    ->VisibleOn('show'),

                                Forms\Components\TextInput::make('quantity')
                                    ->label(__('all.quantity'))
                                    ->numeric()
                                    ->default(1)
                                    ->columnSpan([
                                        'md' => 2,
                                    ])
                                    ->required(),

                                Forms\Components\TextInput::make('unit_price')
                                    ->label(__('all.unit_price'))
                                    ->disabled()
                                    ->suffix('MAD')
                                    ->dehydrated()
                                    ->numeric()
                                    ->required()
                                    ->columnSpan([
                                        'md' => 3,
                                    ]),
                            ])
                            ->defaultItems(0)
                            ->hiddenLabel()
                            ->columns([
                                'md' => 10,
                            ])
                            ->required(),

                    ]),

            ]);
    }




    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(null)
            ->recordAction(null)
            ->striped()
            ->modifyQueryUsing(fn(Builder $query) =>
                $query->filterByUser()->orderByDesc('id')
            )
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->sortable()
                    ->label(__('all.code'))
                    ->searchable(),
                Tables\Columns\ViewColumn::make('products')
                    ->label(__('all.name'))
                    ->view('filament.tables.columns.order-products-column-list')
                    ->searchable(),
                Tables\Columns\TextColumn::make('client')
                    ->sortable()
                    ->label(__('all.client'))
                    ->searchable(),
                Tables\Columns\ViewColumn::make('lastConfirmationState.name')
                    ->label(__('all.confirmation_state'))
                    ->view('filament.tables.columns.status-switcher', ['type' => 'confirmation']),
                Tables\Columns\ViewColumn::make('lastDeliveryState.name')
                    ->label(__('all.delivery_state'))
                    ->view('filament.tables.columns.status-switcher', ['type' => 'delivery']),
                Tables\Columns\TextColumn::make('phone')
                    ->label(__('all.phone'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->label(__('all.price'))
                    ->money('MAD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('city')
                    ->label(__('all.city'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('tracking_code')
                    ->label(__('all.tracking_code'))
                    ->default('N/A')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('all.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('all.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // filter by store 
                Tables\Filters\SelectFilter::make('stores_id')
                        ->options(
                            auth()->user()->hasRole('agent') ?
                                Order::query()
                                    ->filterByUser()
                                    ->select('stores_id')
                                    ->distinct()
                                    ->pluck('stores_id')
                                    ->mapWithKeys(fn($store) => [$store => Store::find($store)->name])
                                    ->toArray()
                            :
                                Store::query()
                                    ->filterByUser()
                                    ->select('id', 'name')
                                    ->pluck('name', 'id')
                                    ->toArray()
                        )
                        ->label(__('all.store')),
                Tables\Filters\SelectFilter::make('city')
                    ->options(
                        Order::query()
                            ->filterByUser()
                            ->select('city')
                            ->distinct()
                            ->pluck('city')
                            ->mapWithKeys(fn($city) => [$city => $city])
                            ->toArray()
                    )
                    ->label(__('all.city')),
                Tables\Filters\Filter::make('created_at')
                    ->label(__('all.created_at'))
                    ->columnSpan(2)
                    ->columns(2)
                    ->form([
                        DatePicker::make('created_from')
                            ->label(__('all.created_from')),
                        DatePicker::make('created_until')
                            ->label(__('all.created_until')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ], layout: FiltersLayout::AboveContent)
            ->headerActions([
                Tables\Actions\BulkActionGroup::make([
                    ExportAction::make()
                        ->label(__('all.export_excel'))
                        ->exporter(OrderExporter::class)
                        ->modifyQueryUsing(
                            fn(Builder $query, $livewire) => OrderProduct::query()->ofStore($livewire->getTableFilterState('stores_id')['value'])
                        )
                        ->formats([
                            ExportFormat::Xlsx,
                        ]),
                    Tables\Actions\Action::make('download_excel')
                        ->label(__('all.download_excel'))
                        ->icon('heroicon-o-document-text')
                        ->slideOver()
                        ->modalContent(
                            view('filament.pages.download_excel', ['exports' => Export::ofUser()->orderByDesc('id')->get()])
                        )->modalSubmitAction(false)
                        ->badge(fn() => Export::ofUser()->count()),
                    ])
                    ->label(__('all.export'))
                    ->icon('heroicon-o-cloud-arrow-down')
                    ->color('info'),

                Tables\Actions\ImportAction::make()
                    ->importer(OrderImporter::class)
                    ->icon('heroicon-o-document-arrow-up')
                    ->label(__('all.import_from_local_file'))
                    ->button()
                    ->options(fn($livewire) => [
                        'store_id' => $livewire->getTableFilterState('stores_id')['value'],
                    ])
                    ->visible(
                        function ($livewire) {
                            $store_id = $livewire->getTableFilterState('stores_id')['value'];
                            $store = Store::where('id', $store_id)->filterByUser()->first();
                            return $store_id ? $store?->adding_order_type == 'import_from_excel' : false;
                        }
                    ),
                Tables\Actions\Action::make('import_google_sheet')
                    ->label(__('all.import_google_sheet'))
                    ->icon('heroicon-o-cloud-arrow-up')
                    ->slideOver()
                    ->modalContent(fn ($livewire): View => view(
                        'filament.tables.actions.import-google-sheet',
                        ['record' => Store::find($livewire->getTableFilterState('stores_id')['value'])],
                    ))
                    ->button()
                    ->modalSubmitAction(false)
                    ->visible(
                        function ($livewire) {
                            auth()->user()->hasRole('agent') ? false :
                            $store_id = $livewire->getTableFilterState('stores_id')['value'];
                            $store = Store::where('id', $store_id)->filterByUser()->first();
                            return $store_id ? $store?->adding_order_type == 'import_from_google_sheet' : false;
                        }
                    ),
                    
                Tables\Actions\CreateAction::make()
                    ->model(Order::class)
                    ->label(__('all.add_order'))
                    ->icon('heroicon-o-plus')
                    ->mountUsing(function (Form $form, $livewire) {
                        $form->fill(['phone' => $livewire->getTableFilterState('stores_id')['value']]);
                    })
                    ->using(function (array $data, string $model, $livewire): Model {
                        $data['stores_id'] = $livewire->getTableFilterState('stores_id')['value'];
                        // TODO : check store id if is for this user
                        return $model::create($data);
                    })
                    ->visible(function ($livewire) {
                        auth()->user()->hasRole('agent') ? false :
                        $store_id = $livewire->getTableFilterState('stores_id')['value'];
                        return $store_id ? Store::find($store_id)?->adding_order_type == 'insert_orders_manually' : false;
                        }),
            ])
            ->actions([
                Tables\Actions\Action::make('order_history')
                    ->label(__('all.order_history'))
                    ->tooltip(__('all.order_history'))
                    ->modalContent(fn(Order $record): View => view(
                        'filament.modals.states-history',
                        ['record' => $record]))
                    ->slideOver()
                    ->modalWidth(MaxWidth::Small)
                    ->modalSubmitAction(false)
                    ->icon('heroicon-o-clock')
                    ->iconButton(),

                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->slideOver(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\Action::make('report')
                        ->label(__('all.report'))
                        ->tooltip(__('all.report'))
                        ->action(
                            fn (Order $order, $livewire) => [
                                $livewire->dispatch('open-modal', id: 'chat-Modal'),
                                $livewire->dispatch('modal-order-id', ['orders_id' => $order->id])
                            ]
                        )
                        ->icon('heroicon-o-exclamation-circle'),
                    Tables\Actions\DeleteAction::make(),

                ])->iconButton(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            //'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }

    protected function getTableRecordActionUsing(): ?Closure
    {
        return null;
    }

    public static function getWidgets(): array
    {
        return [
            OrderStats::class,
        ];
    }

    public static function getModelLabel(): string
    {
        return __('all.order');
    }

    public static function getPluralModelLabel(): string
    {
        return __('all.orders');
    }
}
