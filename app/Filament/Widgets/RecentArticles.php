<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class RecentArticles extends TableWidget
{
    protected static ?int $sort = 4;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Recent articles')
            ->query(fn (): Builder => Article::query()
                ->with('category')
                ->orderByDesc('created_at')
                ->limit(5))
            ->columns([
                TextColumn::make('title')
                    ->weight('semibold')
                    ->limit(45),

                TextColumn::make('category.name')
                    ->badge()
                    ->placeholder('—'),

                IconColumn::make('is_published')
                    ->label('Published')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->paginated(false);
    }
}
