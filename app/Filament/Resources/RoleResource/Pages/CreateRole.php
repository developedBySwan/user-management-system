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

    public function create(bool $another = false): void
    {
        $this->authorizeAccess();

        try {
            DB::beginTransaction();

            $this->callHook('beforeValidate');

            $data = $this->form->getState();

            $this->callHook('afterValidate');

            $data = $this->mutateFormDataBeforeCreate($data);

            $this->callHook('beforeCreate');

            $this->record = $this->handleRecordCreation($data);

            $modifiedData = array_slice($data, 1, count($data));

            $permissionData = array_keys(collect($modifiedData)->filter(fn ($col, $key) => $col == true)->toArray());

            $this->record->permissions()->attach($permissionData);

            $this->form->model($this->getRecord())->saveRelationships();

            $this->callHook('afterCreate');

            DB::commit();
        } catch (Halt $exception) {
            $exception->shouldRollbackDatabaseTransaction() ?
                DB::rollBack() :
                DB::commit();

            return;
        } catch (\Throwable $exception) {
            DB::rollBack();

            throw $exception;
        }

        $this->rememberData();

        $this->getCreatedNotification()?->send();

        if ($another) {
            // Ensure that the form record is anonymized so that relationships aren't loaded.
            $this->form->model($this->getRecord()::class);
            $this->record = null;

            $this->fillForm();

            return;
        }

        $redirectUrl = $this->getRedirectUrl();

        $this->redirect($redirectUrl, navigate: FilamentView::hasSpaMode() && is_app_url($redirectUrl));
    }
}
