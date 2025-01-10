<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentRevisionResource\Pages;
use App\Filament\Resources\DocumentRevisionResource\RelationManagers;
use App\Models\DocumentRevision;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DocumentRevisionResource extends Resource
{
    protected static ?string $model = DocumentRevision::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-check';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('document_id')->disabled(),
                Forms\Components\TextInput::make('revision_number')->disabled(),
                Forms\Components\Select::make('revised_by')->relationship('reviser','name')->disabled(),
                Forms\Components\Select::make('status')->options(['Draft' => 'Draft', 'Disetujui' => 'Disetujui', 'Ditolak' => 'Ditolak']),
                Forms\Components\FileUpload::make('file_path')->label('File Docs')->acceptedFileTypes(['application/pdf','application/msword','application/vnd.openxmlformats-officedocument.wordprocessingml.document','application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation'
                ])->disk('dokumen')->disabled(),
                Forms\Components\TextArea::make('description')->disabled()->columnSpanFull(),
                Forms\Components\TextArea::make('reason')->label('Reason Edited')->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('document.title')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('reviser.name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('revision_number')->sortable(),
                Tables\Columns\TextColumn::make('status')->badge()->icons([
                    'heroicon-o-paper-clip' => 'Draft',
                    'heroicon-o-document-check' => 'Disetujui',
                    'heroicon-o-x-circle' => 'Ditolak',
                ])
                ->colors([
                    'secondary' => 'Draft',
                    'success' => 'Disetujui',
                    'danger' => 'Ditolak'
                ])->sortable(),
                Tables\Columns\TextColumn::make('file_path')
                ->label('File Dokumen')
                ->formatStateUsing(function ($state) {
                    $imageUrl = route('file.dokumen',['filename' => $state]);
                    return "<a href='" . $imageUrl . "' target='_blank' style='margin: 0 5pt 0 0;text-decoration: underline;' class='fi-ta-text-item-label text-sm leading-6 text-gray-950 dark:text-white hover:underline'>Lihat Dokumen</a>";
                })
                ->html(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function canCreate(): bool
    {
       return false;
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDocumentRevisions::route('/'),
            'create' => Pages\CreateDocumentRevision::route('/create'),
            'edit' => Pages\EditDocumentRevision::route('/{record}/edit'),
        ];
    }
}
