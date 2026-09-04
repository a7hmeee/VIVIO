<?php

namespace App\Filament\Widgets;

use App\Enums\LeadStatus;
use App\Models\Lead;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class RecentLeads extends TableWidget
{
    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Recent leads')
            ->query(fn (): Builder => Lead::query()->recent()->limit(5))
            ->columns([
                TextColumn::make('name')
                    ->weight('semibold'),

                TextColumn::make('company')
                    ->placeholder('—'),

                TextColumn::make('project_type')
                    ->badge(),

                TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'info' => LeadStatus::New->value,
                        'primary' => LeadStatus::Contacted->value,
                        'warning' => LeadStatus::Qualified->value,
                        'gray' => LeadStatus::Proposal->value,
                        'success' => LeadStatus::Won->value,
                        'danger' => LeadStatus::Lost->value,
                    ]),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->paginated(false);
    }
}
