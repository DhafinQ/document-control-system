<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentResource\Pages;
use App\Filament\Resources\DocumentResource\RelationManagers;
use App\Models\Document;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')->required(),
                Forms\Components\TextInput::make('category')->numeric()->required(),
                Forms\Components\Select::make('uploaded_by')->relationship('uploader','name')->required(),
                Forms\Components\FileUpload::make('file_path')->label('File Docs')->acceptedFileTypes(['application/pdf','application/msword','application/vnd.openxmlformats-officedocument.wordprocessingml.document','application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation'
                ])->disk('dokumen')->required(),
                Forms\Components\TextArea::make('description')->required()->columnSpanFull(),
                Forms\Components\TextArea::make('reason')->required()->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('category')->sortable(),
                Tables\Columns\TextColumn::make('uploader.name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('currentRevision.file_path')
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

    public static function getPanels(): array
    {
        return [
            'admin' => [
                'label' => 'Admin Panel',
                'pages' => [
                    'index' => Pages\ListDocuments::class,
                    'create' => Pages\CreateDocument::class,
                    'edit' => Pages\EditDocument::class,
                ]
            ]
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDocuments::route('/'),
            'create' => Pages\CreateDocument::route('/create'),
            'edit' => Pages\EditDocument::route('/{record}/edit'),
        ];
    }
}
