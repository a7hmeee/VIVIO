<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Project;
use Livewire\Component;

class ProjectsPage extends Component
{
    public string $activeFilter = 'all';

    public string $search = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function setFilter(string $filter): void
    {
        $this->activeFilter = $filter;
        $this->resetPage();
    }

    public function getProjects()
    {
        $query = Project::published()->ordered()->with(['category', 'media', 'team']);

        if ($this->activeFilter !== 'all') {
            $query->whereHas('category', fn ($q) => $q->where('slug', $this->activeFilter));
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', "%{$this->search}%")
                    ->orWhere('short_description', 'like', "%{$this->search}%")
                    ->orWhere('client', 'like', "%{$this->search}%");
            });
        }

        return $query->get();
    }

    public function getCategories()
    {
        return Category::has('publishedProjects')->ordered()->get();
    }

    public function getStats(): array
    {
        return [
            'projects' => Project::published()->count(),
        ];
    }

    public function render()
    {
        return view('livewire.projects-page', [
            'projects' => $this->getProjects(),
            'categories' => $this->getCategories(),
            'stats' => $this->getStats(),
        ])->layout('components.layout.base', [
            'title' => 'VIVIO — أعمالنا',
            'description' => 'استكشف مشاريع VIVIO وأعمالنا في بناء الأنظمة الرقمية والحلول المتكاملة.',
        ]);
    }
}
