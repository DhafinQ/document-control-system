<?php

namespace App\Filament\Resources\DocumentResource\Pages;

use App\Filament\Resources\DocumentResource;
use App\Models\DocumentRevision;
use App\Models\DocumentHistory;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;

class CreateDocument extends CreateRecord
{
    protected static string $resource = DocumentResource::class;

 
    protected function afterCreate(): void
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
            'revision_number' => 1,
            'description' => $data['description']
        ]);

        $this->record->update([
            'current_revision_id' => $revision->id
        ]);

        DocumentHistory::create([
            'document_id' => $this->record->id,
            'revision_id' => $revision->id,
            'action' => 'Created',
            'performed_by' => $data['uploaded_by'],
            'reason' => $data['reason'],
        ]);
    }
}
