<?php

namespace App\Filament\Resources\DocumentRevisionResource\Pages;

use App\Filament\Resources\DocumentRevisionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDocumentRevisions extends ListRecords
{
    protected static string $resource = DocumentRevisionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
