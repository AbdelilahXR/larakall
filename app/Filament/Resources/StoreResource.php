<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StoreResource\Pages;
use App\Models\Store;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Imports\OrderImporter;
use Illuminate\Contracts\View\View;

class StoreResource extends Resource
{
    protected static ?string $model = Store::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

    protected static ?int $navigationSort = -2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // add grid
                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__('all.name'))
                            ->placeholder(__('all.add_name'))
                            ->required()
                            ->maxLength(45)
                            ->columnSpan(3),
                        Forms\Components\ToggleButtons::make('status')
                            ->label(__('all.status'))
                            ->options([
                                '1' => __('all.active'),
                                '0' => __('all.inactive'),
                            ])
                            ->colors([
                                '1' => 'success',
                                '0' => 'danger',
                            ])
                            ->default('1')
                            ->grouped()
                            ->columnSpan(1),
                    ])
                    ->columns(4),
                Forms\Components\Fieldset::make(__('all.adding_order_options'))
                    ->columns(1)
                    ->schema([
                        Forms\Components\ToggleButtons::make('adding_order_type')
                            ->label(false)
                            ->options([
                                'insert_orders_manually' => __('all.insert_orders_manually'),
                                'import_from_excel' => __('all.import_from_excel'),
                                'import_from_google_sheet' => __('all.import_from_google_sheet'),
                            ])
                            ->colors([
                                'insert_orders_manually' => 'warning',
                                'import_from_excel' => 'success',
                                'import_from_google_sheet' => 'info',
                            ])
                            ->default('insert_orders_manually')
                            ->inline()
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Select::make('users_id')
                    ->required()
                    ->relationship('user', 'name')
                    ->options(\App\Models\User::whereHas('roles', function ($q) {
                        $q->where('name', 'client');
                    })
                            ->pluck('name', 'id')
                            ->toArray())
                    ->preload()
                    ->disabledOn('edit')
                    ->searchable()
                    ->hidden(fn() => !auth()->user()->hasRole('super_admin')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->modifyQueryUsing(fn(Builder $query) =>
                $query->filterByUser()->orderByDesc('id')
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->label(__('all.name'))
                    ->searchable(),
                Tables\Columns\IconColumn::make('status')
                    ->label(__('all.status'))
                    ->icon(fn(Store $record) => $record->status ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
                    ->color(fn(Store $record) => $record->status ? 'success' : 'danger')
                    ->sortable()
                    ->searchable(),
                // Tables\Columns\ViewColumn::make('adding_order_type')
                //     ->label(__('all.adding_order_type'))
                //     ->view('filament.tables.columns.adding-order-handler'),
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable()
                    ->hidden(fn() => !auth()->user()->hasRole('super_admin')),
                Tables\Columns\TextColumn::make('products_count')
                    ->label(__('all.products'))
                    ->numeric()
                    ->default(fn(Store $record) => $record->products()->count()),
                Tables\Columns\TextColumn::make('orders_count')
                    ->label(__('all.orders'))
                    ->numeric()
                    ->default(fn(Store $record) => $record->orders()->count()),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ImportAction::make()
                    ->importer(OrderImporter::class)
                    ->icon('heroicon-o-document-arrow-up')
                    ->label(__('all.import_from_excel'))
                    ->button()
                    ->color('success')
                    ->options(fn (Store $record) => [
                        'store_id' => $record->id,
                    ])
                    ->visible(fn(Store $record) => $record->adding_order_type == 'import_from_excel'),
                Tables\Actions\Action::make('import_google_sheet')
                    ->label(__('all.import_google_sheet'))
                    ->icon('heroicon-o-cloud-arrow-up')
                    ->slideOver()
                    ->modalContent(fn (Store $record): View => view(
                        'filament.tables.actions.import-google-sheet',
                        ['record' => $record],
                    ))
                    ->button()
                    ->color('info')
                    ->modalSubmitAction(false)
                    ->visible(fn(Store $record) => $record->adding_order_type == 'import_from_google_sheet'),
                
                Tables\Actions\CreateAction::make()
                    ->model(Order::class)
                    ->label(__('all.insert_orders_manually'))
                    ->icon('heroicon-o-plus')
                    ->button()
                    ->color('warning')
                    ->url(fn(Store $record) => 'orders?tableFilters[stores_id][value]='. $record->id)
                    ->visible(fn(Store $record) => $record->adding_order_type == 'insert_orders_manually'),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
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
            'index' => Pages\ListStores::route('/'),
            //'create' => Pages\CreateStore::route('/create'),
            //'edit' => Pages\EditStore::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return __('all.store');
    }

    public static function getPluralModelLabel(): string
    {
        return __('all.stores');
    }

}
