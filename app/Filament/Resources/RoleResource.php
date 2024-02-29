<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages;
use App\Models\Permissions\Feature;
use App\Models\Permissions\Role;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    public static function canAccess(): bool
    {
        return can_access('role', 'view');
    }

    public static function canCreate(): bool
    {
        return can_access('role', 'create');
    }

    public static function canEdit(Model $record): bool
    {
        return (bool) (can_access('role', 'update') && static::can('update', $record));
    }

    public static function canDelete(Model $record): bool
    {
        return (bool) (can_access('role', 'delete') && static::can('update', $record));
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                    ]),
                Forms\Components\Section::make()
                    ->schema(static::permissionLists())
                    ->columns(2)
            ]);
    }

    public static function permissionLists(): array
    {
        $permissionLists = [];

        $features = Feature::query()
                    ->with('permissions')
                    ->get();

        foreach($features as $feature) {
            $permissions = [];

            foreach($feature->permissions as $permission) {
                $permissions[] = Forms\Components\Checkbox::make($permission->id)->label($permission->name);
            }

            $permissionLists[] = Fieldset::make($feature->name)
                ->label(($feature->name))
                ->schema($permissions)
                ->columns(8);
        }

        return $permissionLists;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                ->searchable(isIndividual: true, isGlobal: false)
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label(""),
                Tables\Actions\DeleteAction::make()->label(""),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }
}
