<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StockResource\Pages;
use App\Filament\Resources\StockResource\RelationManagers;
use App\Models\Stock;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Grid;
class StockResource extends Resource
{
    protected static ?string $model = Stock::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('reference')
                    ->required()
                    ->default(Stock::generateReference())
                    ->disabled()
                    ->dehydrated()
                    ->maxLength(45),
                Forms\Components\Select::make('stores_id')
                    ->required()
                    ->label(__('all.store'))
                    ->relationship('store', 'name')
                    ->options(
                        auth()->user()->hasRole('super_admin') ?
                        \App\Models\Store::pluck('name', 'id')->toArray() :
                        \App\Models\Store::where('users_id', auth()->id())->pluck('name', 'id')->toArray()
                    )
                    ->preload()
                    ->live()
                    ->searchable(),
                Forms\Components\Section::make(__('all.products'))
                    ->columns(1)
                    ->schema([
                        Forms\Components\Repeater::make('stockProducts')
                            ->relationship()
                            ->schema([
                                Forms\Components\Select::make('products_id')
                                    ->label(__('all.product_name'))
                                    ->options(fn (Forms\Get $get) => Product::where('stores_id', $get('../../stores_id'))->get()->pluck('fullName', 'id')->toArray())
                                    ->required()
                                    ->reactive()
                                    ->distinct()
                                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                    ->columnSpan([
                                        'md' => 5,
                                    ])
                                    ->searchable(),

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
                                    ->placeholder(__('all.unit_price'))
                                    ->suffix('MAD')
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
            ->columns([
                Tables\Columns\ImageColumn::make('productDetail.image_1')
                    ->label(__('all.products'))
                    ->defaultImageUrl(url('storage/products/placeholder.png'))
                    ->circular()
                    ->stacked()
                    ->limit(3)
                    ->limitedRemainingText(),
                Tables\Columns\TextColumn::make('reference')
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('store.name')
                    ->money()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->button(),
                Tables\Actions\EditAction::make()
                    ->button(),
                Tables\Actions\DeleteAction::make()
                    ->button(),
            
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make(__('all.stock_information'))
                    ->schema([
                        Grid::make(1)
                            ->columnspan(1)
                            ->schema([
                                ViewEntry::make('qrCode')
                                    ->view('filament.tools.qr-code')
                            ]),
                        Grid::make(2)
                            ->columnspan(3)
                            ->schema([
                                TextEntry::make('reference')
                                    ->label(__('all.reference')),
                                TextEntry::make('store.name'),
                                TextEntry::make('created_at')
                                    ->dateTime(),
                                TextEntry::make('updated_at')
                                    ->dateTime(),
                            ])
                            ->columns(2),
                    ])
                    ->columns(4),
                Section::make(__('all.stock_products'))
                    ->schema([
                        RepeatableEntry::make('stockProducts')
                            ->label(false)
                            ->schema([
                                ImageEntry::make('product.image_1')
                                    ->label(false)
                                    ->height(55)
                                    ->square(),
                                TextEntry::make('product.name')
                                    ->label(__('all.name'))
                                    ->columnSpan('3'),
                                TextEntry::make('quantity'),
                                TextEntry::make('unit_price')
                                    ->money('MAD'),
                                TextEntry::make('totalPrice')
                                    ->label(__('all.total_price'))
                                    ->money('MAD')
                                    ->columnSpan('2'),
                            ])
                            ->columnSpanFull()
                            ->columns('8')
                    ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }


    // infolist


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStocks::route('/'),
            'create' => Pages\CreateStock::route('/create'),
            'edit' => Pages\EditStock::route('/{record}/edit'),
        ];
    }
}
