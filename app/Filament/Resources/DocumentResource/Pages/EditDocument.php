<?php

namespace App\Filament\Resources\DocumentResource\Pages;

use App\Filament\Resources\DocumentResource;
use App\Models\DocumentHistory;
use App\Models\DocumentRevision;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDocument extends EditRecord
{
    protected static string $resource = DocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $data = $this->data;
        $path = $data['file_path'];

        foreach ($path as $key => $f) {
            $filename = $f;
        }

        $revision = DocumentRevision::create([
            'document_id' => $this->record->id,
            'file_path' => $filename,
            'revised_by' => $data['uploaded_by'],
            'revision_number' => $this->record->currentRevision->revision_number+1,
            'description' => $data['description']
        ]);

        $this->record->update([
            'current_revision_id' => $revision->id
        ]);

        DocumentHistory::create([
            'document_id' => $this->record->id,
            'revision_id' => $revision->id,
            'action' => 'Revised',
            'performed_by' => $data['uploaded_by'],
            'reason' => $data['reason'],
        ]);
    }

}
