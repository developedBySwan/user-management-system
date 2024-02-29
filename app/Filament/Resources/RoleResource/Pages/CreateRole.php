<?php

namespace App\Filament\Resources\RoleResource\Pages;

use Illuminate\Support\Facades\DB;
use App\Filament\Resources\RoleResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Facades\FilamentView;
use Filament\Support\Exceptions\Halt;

use function Filament\Support\is_app_url;

class CreateRole extends CreateRecord
{
    protected static string $resource = RoleResource::class;

    public function afterCreate(): void
    {
        $data = $this->form->getState();

        $modifiedData = array_slice($data, 1, count($data));

        $permissionData = array_keys(collect($modifiedData)->filter(fn ($col, $key) => $col == true)->toArray());

        $this->record->permissions()->attach($permissionData);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
