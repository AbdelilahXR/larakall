<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use Filament\Support\Enums\Alignment;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Grid;
class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    //protected static ?string $navigationGroup = 'Shop';

    protected static ?int $navigationSort = -2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__('all.name'))
                            ->placeholder(__('all.enter_name'))
                            ->required()
                            ->maxLength(16)
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Textarea::make('description')
                    ->label(__('all.description'))
                    ->placeholder(__('all.enter_description'))
                    ->rows(4)
                    ->maxLength(45)
                    ->columnSpanFull(),
                Forms\Components\Section::make(__('all.product_details'))
                    ->columns(2)
                    ->schema([
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
                        Forms\Components\TextInput::make('link')
                            ->required()
                            ->prefix('https://')
                            ->label(__('all.link'))
                            ->placeholder(__('all.enter_link'))
                            ->maxLength(45),
                        Forms\Components\TextInput::make('min_price')
                            ->required()
                            ->prefix('MAD')
                            ->label(__('all.min_price'))
                            ->placeholder(__('all.enter_min_price'))
                            ->live()
                            ->maxValue(fn (Get $get) => $get('max_price') ?: 0)
                            ->numeric(),
                        Forms\Components\TextInput::make('max_price')
                            ->required()
                            ->prefix('MAD')
                            ->label(__('all.max_price'))
                            ->placeholder(__('all.enter_max_price'))
                            ->live()
                            ->minValue(fn (Get $get) => $get('min_price') ?: 0)
                            ->numeric(),
                    ]),
                Forms\Components\Textarea::make('script')
                    ->label(__('all.script'))
                    ->placeholder(__('all.enter_script'))
                    ->maxLength(45)
                    ->rows(3)
                    ->columnSpanFull(),
                Forms\Components\TagsInput::make('upsell')
                    ->label(__('all.upsell'))
                    ->placeholder(__('all.enter_upsell'))
                    ->columnSpanFull(),
                Forms\Components\Section::make(__('all.images'))
                    ->columns(3)
                    ->schema([
                        Forms\Components\FileUpload::make('image_1')
                            ->label(__('all.image_1'))
                            ->directory('products')
                            ->maxSize(1024)
                            ->image(),
                        Forms\Components\FileUpload::make('image_2')
                            ->label(__('all.image_2'))
                            ->directory('products')
                            ->maxSize(1024)
                            ->image(),
                        Forms\Components\FileUpload::make('image_3')
                            ->label(__('all.image_3'))
                            ->maxSize(1024)
                            ->directory('products')
                            ->image(),
                    ]),
                Forms\Components\Section::make(__('all.variants'))
                    ->columns(1)
                    ->schema([
                        Forms\Components\Repeater::make('variants')
                            ->relationship()
                            ->schema([
                                Forms\Components\Grid::make(2)
                                    ->columnspan(1)
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->label(__('all.name'))
                                            ->placeholder(__('all.enter_name'))
                                            ->required()
                                            ->columnspanfull(),
                                        Forms\Components\TextInput::make('min_price')
                                            ->label(__('all.min_price'))
                                            ->placeholder(__('all.enter_min_price'))
                                            ->required()
                                            ->numeric(),
                                        Forms\Components\TextInput::make('max_price')
                                            ->label(__('all.max_price'))
                                            ->placeholder(__('all.enter_max_price'))
                                            ->required()
                                            ->numeric(),
                                    ]),
                                Forms\Components\Grid::make(1)
                                    ->columnspan(1)
                                    ->schema([
                                        Forms\Components\FileUpload::make('image_1')
                                            ->label(__('all.image'))
                                            ->directory('products')
                                            ->maxSize(1024)
                                            ->image(),
                                    ]),
                            ])
                            ->defaultItems(0)
                            ->hiddenLabel()
                            ->columns(2)
                            ->mutateRelationshipDataBeforeSaveUsing(function (array $data, Get $get, Product $record): array {
                                $data['stores_id'] = $get('stores_id') ?? $record('stores_id');
                                $data['type'] = 'variant';
                                return $data;
                            })
                            ->mutateRelationshipDataBeforeCreateUsing(function (array $data, Get $get): array {
                                $data['stores_id'] = $get('stores_id');
                                $data['type'] = 'variant';
                                return $data;
                            }),

                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->modifyQueryUsing(fn(Builder $query) =>
                $query->filterByUser()->where('type', 'simple')->orderByDesc('id')
            )
            ->columns([
                Tables\Columns\ImageColumn::make('image_1')
                    ->label(__('all.image'))
                    ->defaultImageUrl(url('storage/products/placeholder.png'))
                    ->circular(),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('all.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('min_price')
                    ->label(__('all.min_price'))
                    ->money('MAD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('max_price')
                    ->label(__('all.max_price'))
                    ->money('MAD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('variants_count')
                    ->label(__('all.variants'))
                    ->default(fn(Product $record) => $record->variants()->count())
                    ->sortable(),
                Tables\Columns\TextColumn::make('store.name')
                    ->label(__('all.store'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('stockProductsWithVariantsCount')
                    ->label(__('all.in_stock'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->since()
                    ->tooltip(fn(Product $record) => $record->created_at->toDateString())
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // by store
                Tables\Filters\SelectFilter::make('stores_id')
                    ->label(__('all.store'))
                    ->options(
                        auth()->user()->hasRole('super_admin') ?
                        \App\Models\Store::pluck('name', 'id')->toArray() :
                        \App\Models\Store::where('users_id', auth()->id())->pluck('name', 'id')->toArray()
                    )->preload()
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->button()
                    ->slideOver(),
                Tables\Actions\LinkAction::make('link')
                    ->button()
                    ->label(__('all.go_to'))
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->openUrlInNewTab()
                    ->url(fn(Product $record) => 'http://' . $record->link)
                    ->openUrlInNewTab(),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->button(),
                    Tables\Actions\DeleteAction::make()
                        ->button(),
                ]),
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
                Section::make(__('all.default_product_information'))
                    ->schema([
                        Grid::make(1)
                            ->columnspan(2)
                            ->schema([
                                ViewEntry::make('image_1')
                                    ->view('filament.tools.slider')

                            ])
                            ->columns(1),
                        Grid::make(2)
                            ->columnspan(3)
                            ->schema([
                                TextEntry::make('name')
                                    ->label(__('all.name'))
                                    ->columnSpanFull(),
                                TextEntry::make('min_price')
                                    ->label(__('all.min_price'))
                                    ->money('MAD'),
                                
                                TextEntry::make('max_price')
                                    ->label(__('all.max_price'))
                                    ->money('MAD'),
                                TextEntry::make('stockProductsCount')
                                    ->icon(
                                        fn (Product $record) => $record->stockProductsCount > 0 ? 'heroicon-c-check-circle' : 'heroicon-s-exclamation-circle'
                                    )
                                    ->iconColor(
                                        fn (Product $record) => $record->stockProductsCount > 0 ? 'success' : 'danger'
                                    )
                                    ->label(__('all.product_stock')),
                                TextEntry::make('stockProductsWithVariantsCount')
                                    ->icon(
                                        fn (Product $record) => $record->stockProductsWithVariantsCount > 0 ? 'heroicon-c-check-circle' : 'heroicon-s-exclamation-circle'
                                    )
                                    ->iconColor(
                                        fn (Product $record) => $record->stockProductsWithVariantsCount > 0 ? 'success' : 'danger'
                                    )
                                    ->label(__('all.total_stock')),
                            ]),
                            Grid::make(1)
                                ->columnspan(3)
                                ->schema([
                                    TextEntry::make('description')
                                        ->label(__('all.description'))
                                        ->columnSpan(2),
                                    TextEntry::make('status')
                                        ->label(__('all.status'))
                                        ->badge()
                                        ->default(
                                            fn (Product $record) => $record->stockProductsWithVariantsCount > 0 ? __('all.in_stock') : __('all.out_of_stock')
                                        )
                                        ->color(
                                            fn (Product $record) => $record->stockProductsWithVariantsCount > 0 ? 'success' : 'danger'
                                        ),
                                    TextEntry::make('store.name')
                                        ->label(__('all.store')),
                                    TextEntry::make('created_at')
                                        ->label(__('all.created_at'))
                                        ->dateTime(),
                                    TextEntry::make('updated_at')
                                        ->label(__('all.updated_at'))
                                        ->dateTime(),
                                ])->columns(3)->columnSpanFull()
                    ])->columns(5),
                    Section::make(__('all.variant_product_information'))
                        ->schema([
                            RepeatableEntry::make('variants')
                                ->label(false)
                                ->schema([
                                    ImageEntry::make('image_1')
                                        ->label(false)
                                        ->height(55)
                                        ->square(),
                                    TextEntry::make('name')
                                        ->label(__('all.name'))
                                        ->columnSpan('2'),
                                    TextEntry::make('min_price')
                                        ->label(__('all.min_price'))
                                        ->money('MAD'),
                                    TextEntry::make('max_price')
                                        ->label(__('all.max_price'))
                                        ->money('MAD'),
                                    TextEntry::make('stockProductsCount')
                                        ->icon('heroicon-c-check-circle')
                                        ->iconColor('success')
                                        ->label(__('all.product_stock')),
                                ])
                                ->columns(6)
                        ])

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
            'index' => Pages\ManageProducts::route('/'),
            // 'create' => Pages\CreateProduct::route('/create'),
            // 'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return __('all.product');
    }

    public static function getPluralModelLabel(): string
    {
        return __('all.products');
    }

    // sort 1

}
