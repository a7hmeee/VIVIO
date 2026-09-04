<?php

namespace App\Filament\Resources\Projects\RelationManagers;

use App\Models\TeamMember;
use Filament\Actions\AttachAction;
use Filament\Actions\DetachAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TeamRelationManager extends RelationManager
{
    protected static string $relationship = 'team';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('role_on_project')->label('Project role'),
                TextColumn::make('contribution_percent')->label('Contribution')->suffix('%'),
            ])
            ->headerActions([
                AttachAction::make()
                    ->label('Add team member')
                    ->recordSelectSearchColumns(['name', 'role'])
                    ->recordSelectOptions(fn () => TeamMember::active()->orderBy('sort_order')->pluck('name', 'id'))
                    ->form([
                        TextInput::make('role_on_project')->maxLength(255),
                        TextInput::make('contribution_percent')->numeric()->minValue(0)->maxValue(100)->integer(),
                    ]),
            ])
            ->recordActions([
                DetachAction::make(),
            ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }
}
