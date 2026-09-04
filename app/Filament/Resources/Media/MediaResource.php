<?php

namespace App\Filament\Resources\Media;

use App\Filament\Resources\Media\Pages\ManageMedia;
use App\Models\Media as MediaModel;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class MediaResource extends Resource
{
    protected static ?string $model = MediaModel::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static string|UnitEnum|null $navigationGroup = 'Content';

    protected static ?int $navigationSort = 4;

    protected static ?string $modelLabel = 'Media asset';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Select::make('type')
                    ->options([
                        'image' => 'Image',
                        'video' => 'Video',
                        'document' => 'Document',
                    ])
                    ->required()
                    ->live()
                    ->default('image'),

                FileUpload::make('file_path')
                    ->label('File')
                    ->disk('public')
                    ->directory('media')
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
                    ->maxLength(255),

                TextInput::make('caption')
                    ->maxLength(255),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('file_path')
                    ->disk('public')
                    ->visible(fn ($record) => $record?->isImage()),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('semibold'),

                TextColumn::make('type')
                    ->badge()
                    ->colors([
                        'primary' => 'image',
                        'warning' => 'video',
                        'gray' => 'document',
                    ])
                    ->sortable(),

                TextColumn::make('mime_type')
                    ->toggleable(),

                TextColumn::make('human_size')
                    ->label('Size')
                    ->toggleable(),

                TextColumn::make('uploadedBy.name')
                    ->label('Uploaded by')
                    ->placeholder('—')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
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
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageMedia::route('/'),
        ];
    }
}
