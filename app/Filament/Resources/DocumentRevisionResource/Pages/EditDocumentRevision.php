<?php

namespace App\Filament\Resources\DocumentRevisionResource\Pages;

use App\Filament\Resources\DocumentRevisionResource;
use App\Models\DocumentHistory;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditDocumentRevision extends EditRecord
{
    protected static string $resource = DocumentRevisionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $data = $this->data;

        if($this->record->status == 'Disetujui'){
            $datas=[
                'document_id' => $this->record->document->id,
                'revision_id' => $this->record->id,
                'action' => 'Approved',
                'performed_by' => Auth::id(),
                'reason' => $data['reason'],
            ];
        }else{
            $datas=[
                'document_id' => $this->record->document->id,
                'revision_id' => $this->record->id,
                'action' => 'Rejected',
                'performed_by' => Auth::id(),
                'reason' => $data['reason'],
            ];
        }

        DocumentHistory::create($datas);
    }
}
