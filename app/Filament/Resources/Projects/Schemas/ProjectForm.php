<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Basics')
                    ->description('Core project identity and classification.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $operation, $state, callable $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),

                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->alphaDash(),

                        Select::make('category_id')
                            ->relationship('category', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                                TextInput::make('slug')
                                    ->required()
                                    ->alphaDash(),
                            ]),

                        TextInput::make('client')
                            ->maxLength(255),

                        TextInput::make('short_description')
                            ->label('Short description')
                            ->maxLength(500)
                            ->columnSpanFull(),

                        TagsInput::make('technologies')
                            ->suggestions([
                                'Laravel',
                                'Livewire',
                                'Tailwind CSS',
                                'Filament',
                                'React',
                                'Vue.js',
                                'Three.js',
                                'GSAP',
                                'Figma',
                            ])
                            ->columnSpanFull(),
                    ]),

                Section::make('Case Study')
                    ->description('The narrative sections shown on the project page.')
                    ->columns(1)
                    ->schema([
                        Textarea::make('problem')
                            ->rows(4),

                        Textarea::make('approach')
                            ->rows(4),

                        Textarea::make('solution')
                            ->rows(4),

                        Textarea::make('result')
                            ->rows(4),
                    ]),

                Fieldset::make('Media')
                    ->columns(2)
                    ->schema([
                        FileUpload::make('featured_image')
                            ->image()
                            ->imageEditor()
                            ->directory('projects/images')
                            ->disk('public')
                            ->maxSize(5120)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/avif']),

                        FileUpload::make('desktop_image')
                            ->label('Desktop project image')
                            ->image()
                            ->directory('projects/images')
                            ->disk('public')
                            ->maxSize(5120)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/avif']),

                        FileUpload::make('mobile_image')
                            ->label('Mobile project image')
                            ->image()
                            ->directory('projects/images')
                            ->disk('public')
                            ->maxSize(5120)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/avif']),

                        FileUpload::make('video')
                            ->label('Video file (optional)')
                            ->directory('projects/videos')
                            ->disk('public')
                            ->maxSize(102400)
                            ->acceptedFileTypes(['video/mp4', 'video/webm'])
                            ->columnSpanFull(),
                    ]),

                Section::make('Publication')
                    ->description('Visibility and ordering controls.')
                    ->columns(2)
                    ->schema([
                        Toggle::make('is_featured')
                            ->label('Featured on homepage'),

                        Toggle::make('is_published')
                            ->label('Published')
                            ->live()
                            ->afterStateUpdated(function (?bool $state, Set $set, Get $get) {
                                if ($state && blank($get('published_at'))) {
                                    $set('published_at', now());
                                }
                            }),

                        DateTimePicker::make('published_at')
                            ->native(false)
                            ->displayFormat('Y-m-d H:i'),

                        TextInput::make('year')
                            ->numeric()
                            ->minValue(2000)
                            ->maxValue(2100)
                            ->default(date('Y')),

                        TextInput::make('sort_order')
                            ->numeric()
                            ->integer()
                            ->default(0),
                    ]),
            ]);
    }
}
