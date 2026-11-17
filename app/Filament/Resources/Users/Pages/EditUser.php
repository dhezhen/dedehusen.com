<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Validation\ValidationException;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    public function getTitle(): string
    {
        return 'Ubah pengguna';
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $isRemovingAdminAccess = array_key_exists('is_admin', $data) && ! (bool) $data['is_admin'];

        if ($isRemovingAdminAccess && $this->record->is(auth()->user())) {
            throw ValidationException::withMessages([
                'data.is_admin' => 'Akses admin akun yang sedang digunakan tidak dapat dicabut.',
            ]);
        }

        if ($isRemovingAdminAccess && $this->record->is_admin && ! User::query()
            ->where('is_admin', true)
            ->where('id', '!=', $this->record->getKey())
            ->exists()) {
            throw ValidationException::withMessages([
                'data.is_admin' => 'Akun admin terakhir harus dipertahankan.',
            ]);
        }

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function getSaveFormAction(): Action
    {
        return parent::getSaveFormAction()->label('Simpan perubahan');
    }

    protected function getCancelFormAction(): Action
    {
        return parent::getCancelFormAction()->label('Batal');
    }
}
