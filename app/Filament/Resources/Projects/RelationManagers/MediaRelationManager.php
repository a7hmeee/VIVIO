<?php

namespace App\Filament\Resources\Projects\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MediaRelationManager extends RelationManager
{
    protected static string $relationship = 'media';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('type')
                    ->options([
                        'image' => 'Image',
                        'video' => 'Video',
                        'document' => 'Document',
                    ])
                    ->required()
                    ->live()
                    ->default('image'),

                FileUpload::make('path')
                    ->label('File')
                    ->disk('public')
                    ->required()
                    ->maxSize(fn (callable $get) => match ($get('type')) {
                        'video' => 102400,
                        default => 10240,
                    })
                    ->acceptedFileTypes(fn (callable $get) => match ($get('type')) {
                        'image' => ['image/jpeg', 'image/png', 'image/webp', 'image/avif'],
                        'video' => ['video/mp4', 'video/webm'],
                        'document' => ['application/pdf'],
                        default => [],
                    }),

                TextInput::make('alt_text')
                    ->label('Alt text')
                    ->maxLength(255),

                TextInput::make('caption')
                    ->maxLength(255),

                TextInput::make('sort_order')
                    ->numeric()
                    ->integer()
                    ->default(0),
            ])
            ->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('path')
            ->columns([
                ImageColumn::make('path')
                    ->disk('public')
                    ->visible(fn ($record) => $record?->isImage()),

                TextColumn::make('type')
                    ->badge()
                    ->colors([
                        'primary' => 'image',
                        'warning' => 'video',
                        'gray' => 'document',
                    ])
                    ->sortable(),

                TextColumn::make('path')
                    ->limit(40)
                    ->searchable(),

                TextColumn::make('alt_text')
                    ->limit(30)
                    ->toggleable(),

                TextColumn::make('caption')
                    ->limit(30)
                    ->toggleable(),

                TextColumn::make('sort_order')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order');
    }
}
