<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentHistoryResource\Pages;
use App\Filament\Resources\DocumentHistoryResource\RelationManagers;
use App\Models\DocumentHistory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DocumentHistoryResource extends Resource
{
    protected static ?string $model = DocumentHistory::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('document_id')->label('Document Title')->relationship('document','title'),
                Forms\Components\Select::make('revision_id')->label('Reviser')->relationship('revision', 'document_id', fn ($query) => $query->with('reviser'))
                ->getOptionLabelFromRecordUsing(fn ($record) => $record->reviser->name),
                Forms\Components\Select::make('action')->options(['Created' => 'Created', 'Approved' => 'Approved', 'Rejected' => 'Rejected', 'Revised' => 'Revised']),
                Forms\Components\Select::make('performed_by')->relationship('performer','name'),
                Forms\Components\TextArea::make('reason')->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('document.title')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('revision.reviser.name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('revision.revision_number')->label('Revision Number'),
                Tables\Columns\TextColumn::make('action')->badge()->icons([
                    'heroicon-o-document-plus' => 'Created',
                    'heroicon-o-document-arrow-up' => 'Revised',
                    'heroicon-o-document-check' => 'Approved',
                    'heroicon-o-x-circle' => 'Rejected',
                ])
                ->colors([
                    'primary' => 'Created',
                    'warning' => 'Revised',
                    'success' => 'Approved',
                    'danger' => 'Rejected',
                ])->sortable(),
                Tables\Columns\TextColumn::make('performer.name'),
                ])
            ->filters([
            //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListDocumentHistories::route('/'),
            'create' => Pages\CreateDocumentHistory::route('/create'),
            'edit' => Pages\EditDocumentHistory::route('/{record}/edit'),
        ];
    }
}
