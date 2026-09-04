<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ManageSettings extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string|UnitEnum|null $navigationGroup = 'System';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Settings';

    protected static ?string $title = 'Site Settings';

    protected string $view = 'filament.pages.manage-settings';

    public array $data = [];

    public function mount(): void
    {
        $this->data = [
            'site_name' => Setting::get('site_name', config('app.name')),
            'contact_email' => Setting::get('contact_email'),
            'phone' => Setting::get('phone'),
            'whatsapp' => Setting::get('whatsapp'),
            'instagram' => Setting::get('instagram'),
            'linkedin' => Setting::get('linkedin'),
            'x' => Setting::get('x'),
            'default_seo_title' => Setting::get('default_seo_title'),
            'default_seo_description' => Setting::get('default_seo_description'),
        ];
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Brand')
                    ->description('Site identity and branding assets.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('data.site_name')
                            ->label('Site name')
                            ->maxLength(255),
                    ]),

                Section::make('Contact')
                    ->description('How people reach you.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('data.contact_email')
                            ->label('Contact email')
                            ->email()
                            ->maxLength(255),

                        TextInput::make('data.phone')
                            ->label('Phone')
                            ->tel()
                            ->maxLength(255),

                        TextInput::make('data.whatsapp')
                            ->label('WhatsApp')
                            ->url()
                            ->maxLength(255),
                    ]),

                Section::make('Social')
                    ->description('Social media profiles.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('data.instagram')
                            ->label('Instagram URL')
                            ->url()
                            ->maxLength(255),

                        TextInput::make('data.linkedin')
                            ->label('LinkedIn URL')
                            ->url()
                            ->maxLength(255),

                        TextInput::make('data.x')
                            ->label('X (Twitter) URL')
                            ->url()
                            ->maxLength(255),
                    ]),

                Section::make('SEO')
                    ->description('Default search engine optimization settings.')
                    ->columns(1)
                    ->schema([
                        TextInput::make('data.default_seo_title')
                            ->label('Default SEO title')
                            ->maxLength(255),

                        Textarea::make('data.default_seo_description')
                            ->label('Default SEO description')
                            ->maxLength(500)
                            ->rows(3),

                        FileUpload::make('data.default_og_image')
                            ->label('Default OG image')
                            ->image()
                            ->directory('settings')
                            ->disk('public')
                            ->maxSize(5120)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp']),
                    ]),
            ]);
    }

    public function save(): void
    {
        $state = $this->form->getState();

        foreach ($state['data'] ?? [] as $key => $value) {
            if ($value !== null) {
                Setting::set($key, is_array($value) ? implode(',', array_filter($value)) : $value);
            }
        }

        Notification::make()
            ->title('Settings saved')
            ->success()
            ->send();
    }
}
