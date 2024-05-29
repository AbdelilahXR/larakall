<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;
class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('all.name'))
                    ->required()
                    ->maxLength(25),
                Forms\Components\TextInput::make('email')
                    ->label(__('all.email'))
                    ->required()
                    ->email()
                    ->maxLength(65),
                Forms\Components\Select::make('roles')
                    ->label(__('all.roles'))
                    ->relationship('roles', 'name')
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('password')
                    ->label(__('all.password'))
                    ->maxLength(45)
                    ->visibleOn('create')
                    ->password()
                    ->dehydrateStateUsing(fn($state) => Hash::make($state))
                    ->dehydrated(fn($state) => filled($state)),
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
                Tables\Filters\SelectFilter::make('roles')
                    ->label(__('all.roles'))
                    ->native(false)
                    ->relationship('roles', 'name'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                
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
            'index' => Pages\ListUsers::route('/'),
            //'create' => Pages\CreateUser::route('/create'),
            //'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
