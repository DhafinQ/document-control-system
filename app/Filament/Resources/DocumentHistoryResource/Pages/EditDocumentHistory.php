<?php

namespace App\Filament\Resources\DocumentHistoryResource\Pages;

use App\Filament\Resources\DocumentHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDocumentHistory extends EditRecord
{
    protected static string $resource = DocumentHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
