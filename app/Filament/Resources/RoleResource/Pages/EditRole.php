<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Filament\Resources\RoleResource;
use App\Models\Permissions\Role;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EditRole extends EditRecord
{
    protected static string $resource = RoleResource::class;

    protected function resolveRecord(int | string $key): Model
    {
        return Role::query()
            ->with('permissions')
            ->findOrFail($key);
    }

    /**
     * @internal Never override or call this method. If you completely override `fillForm()`, copy the contents of this method into your override.
     *
     * @param  array<string, mixed>  $extraData
     */
    protected function fillFormWithDataAndCallHooks(Model $record, array $extraData = []): void
    {
        $this->callHook('beforeFill');

        $permissions = [];

        foreach($record->permissions as $permission) {
            $permissions[$permission->id] = true;
        }

        $data = $this->mutateFormDataBeforeFill([
            ...$record->attributesToArray(),
            ...$extraData,
            ...$permissions,
        ]);

        $this->form->fill($data);

        $this->callHook('afterFill');
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $modifiedData = array_slice($data, 1, count($data));

        $permissionData = array_keys(collect($modifiedData)->filter(fn($col, $key) => $col == true)->toArray());

        $record->permissions()->sync($permissionData);

        $record->update($data);
    
        return $record;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
