<?php

namespace App\Filament\Resources\Testimonials;

use App\Filament\Resources\Testimonials\Pages\ManageTestimonials;
use App\Models\Client;
use App\Models\Project;
use App\Models\Testimonial;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleLeftRight;

    protected static string|UnitEnum|null $navigationGroup = 'Business';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('client_id')
                    ->label('Linked client')
                    ->options(fn () => Client::query()->orderBy('name')->pluck('name', 'id'))
                    ->searchable()
                    ->nullable(),

                Select::make('project_id')
                    ->label('Linked project')
                    ->options(fn () => Project::query()->orderBy('title')->pluck('title', 'id'))
                    ->searchable()
                    ->nullable(),

                TextInput::make('client_name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('company')
                    ->maxLength(255),

                TextInput::make('position')
                    ->maxLength(255),

                Textarea::make('quote')
                    ->required()
                    ->rows(4)
                    ->columnSpanFull(),

                FileUpload::make('avatar')
                    ->image()
                    ->circular()
                    ->directory('testimonials/avatars')
                    ->disk('public')
                    ->maxSize(2048)
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp']),

                Toggle::make('is_featured')
                    ->label('Featured'),

                Toggle::make('is_published')
                    ->label('Published'),

                TextInput::make('sort_order')
                    ->numeric()
                    ->integer()
                    ->default(0),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('avatar')
                    ->disk('public')
                    ->circular()
                    ->size(42),

                TextColumn::make('client_name')
                    ->searchable()
                    ->sortable()
                    ->weight('semibold'),

                TextColumn::make('company')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('quote')
                    ->limit(60)
                    ->tooltip(fn ($record) => $record->quote),

                TextColumn::make('project.title')
                    ->label('Project')
                    ->placeholder('—')
                    ->toggleable(),

                IconColumn::make('is_published')
                    ->label('Published')
                    ->boolean()
                    ->toggleable(),

                IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean()
                    ->toggleable(),

                TextColumn::make('sort_order')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            ->defaultSort('sort_order');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageTestimonials::route('/'),
        ];
    }
}
