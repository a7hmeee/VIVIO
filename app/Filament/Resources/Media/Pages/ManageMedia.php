<?php

namespace App\Filament\Resources\Media\Pages;

use App\Filament\Resources\Media\MediaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ManageMedia extends ManageRecords
{
    protected static string $resource = MediaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->mutateFormDataUsing(function (array $data): array {
                    $file = $data['file_path'] ?? null;

                    if ($file instanceof TemporaryUploadedFile) {
                        $data['mime_type'] = $file->getMimeType();
                        $data['size'] = $file->getSize();
                        $data['file_path'] = $file->store('media', 'public');
                    }

                    $data['uploaded_by'] = auth()->id();

                    return $data;
                }),
        ];
    }
}
