<?php

namespace App\Filament\Resources\DocumentHistoryResource\Pages;

use App\Filament\Resources\DocumentHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDocumentHistories extends ListRecords
{
    protected static string $resource = DocumentHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
