<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AgentResource\Pages;
use App\Filament\Resources\AgentResource\RelationManagers;
use App\Models\User as Agent;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AgentResource extends Resource
{
    protected static ?string $model = Agent::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) =>
                $query->onlyAgents()
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->label(__('all.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->sortable()
                    ->label(__('all.email'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('roles.name')
                    ->label(__('all.roles'))
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->icon(fn ($record) => match ($record->roles->first()->name) {
                        'super_admin' => 'heroicon-o-user-circle',
                        'agent' => 'heroicon-o-phone-arrow-up-right',
                        'client' => 'heroicon-o-users',
                    })
                    ->color(fn ($record) => match ($record->roles->first()->name) {
                        'super_admin' => 'success',
                        'agent' => 'info',
                        'client' => 'primary',
                    }),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->sortable()
                    ->label(__('all.created'))
                    ->searchable()
                    ->since(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->button()
                    ->slideOver(),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageAgents::route('/'),
        ];
    }

    public static function getModelLabel(): string
    {
        return __('all.agent');
    }

    public static function getPluralModelLabel(): string
    {
        return __('all.agents');
    }
}
