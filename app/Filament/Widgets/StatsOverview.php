<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use App\Models\Client;
use App\Models\Lead;
use App\Models\Project;
use App\Models\Testimonial;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Projects', Project::count())
                ->description(Project::published()->count().' published · '.Project::where('is_published', false)->count().' drafts')
                ->icon('heroicon-o-briefcase'),

            Stat::make('Articles', Article::count())
                ->description(Article::published()->count().' published · '.Article::draft()->count().' drafts')
                ->icon('heroicon-o-document-text'),

            Stat::make('Leads', Lead::count())
                ->description(Lead::new()->count().' new')
                ->color(Lead::new()->count() > 0 ? 'success' : 'gray')
                ->icon('heroicon-o-inbox-arrow-down'),

            Stat::make('Testimonials', Testimonial::count())
                ->description(Testimonial::published()->count().' published')
                ->icon('heroicon-o-chat-bubble-left-right'),

            Stat::make('Clients', Client::count())
                ->description(Client::featured()->count().' featured')
                ->icon('heroicon-o-building-office-2'),
        ];
    }
}
