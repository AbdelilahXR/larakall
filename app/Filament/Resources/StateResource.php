<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StateResource\Pages;
use App\Filament\Resources\StateResource\RelationManagers;
use App\Models\State;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StateResource extends Resource
{
    protected static ?string $model = State::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = -2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('all.name'))
                    ->required()
                    ->maxLength(25),
                Forms\Components\ColorPicker::make('color')
                    ->required()
                    ->label(__('all.color')),
                Forms\Components\Select::make('type')
                    ->required()
                    ->label(__('all.type'))
                    ->options([
                        'confirmation' => 'Confirmation',
                        'delivery' => 'Delivery',
                    ]),
                // toggle to show_stat
                Forms\Components\Toggle::make('show_stat')
                    ->label(__('all.show_stat'))
                    ->inline(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->label(__('all.name'))
                    ->searchable(),
                Tables\Columns\ColorColumn::make('color')
                    ->label(__('all.color'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->sortable()
                    ->label(__('all.type'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'confirmation' => 'warning',
                        'delivery' => 'success',
                    })
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('show_stat')
                    ->label(__('all.show_stat')),
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
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListStates::route('/'),
            //'create' => Pages\CreateState::route('/create'),
            //'edit' => Pages\EditState::route('/{record}/edit'),
        ];
    }



    public static function getModelLabel(): string
    {
        return __('all.state');
    }

    public static function getPluralModelLabel(): string
    {
        return __('all.states');
    }

}
