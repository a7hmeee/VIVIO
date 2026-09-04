@props([
    'technologies' => collect(),
])

<section class="vivio-tech" id="technology" data-section="07">
    <div class="vivio-container">
        <div class="vivio-tech__head">
            <span class="vivio-overline">VIVIO / 07 · TECHNOLOGY</span>
            <h2 class="vivio-serif">التقنية عندنا وسيلة.<br><em>مش استعراض.</em></h2>
            <p class="vivio-tech__lead">من الـBackend والـFrontend، إلى البيانات والبنية التحتية — نبني النظام كامل، مش جزء منه.</p>
        </div>

        <div class="vivio-tech__system" data-tech-system>
            @foreach ([
                ['group' => 'BACKEND', 'items' => ['PHP', 'Laravel', 'MVC', 'Eloquent ORM', 'Middleware', 'REST APIs', 'Node.js', 'Express.js']],
                ['group' => 'FRONTEND', 'items' => ['JavaScript ES6+', 'TypeScript', 'React', 'Livewire', 'HTML5', 'CSS3', 'Tailwind CSS']],
                ['group' => 'DATA', 'items' => ['MySQL', 'PostgreSQL', 'MongoDB']],
                ['group' => 'ARCHITECTURE', 'items' => ['OOP', 'SOLID', 'Modular Design', 'DDD', 'Actions', 'DTOs', 'Repositories']],
                ['group' => 'SECURITY', 'items' => ['Authentication', 'RBAC', 'Policies', 'Validation', 'Tenant Isolation']],
                ['group' => 'INFRASTRUCTURE', 'items' => ['Git', 'GitHub', 'Docker', 'Linux', 'Postman', 'Vite', 'CI/CD']],
            ] as $techGroup)
                <div class="vivio-tech__group" data-tech-group>
                    <div class="vivio-tech__group-label">{{ $techGroup['group'] }}</div>
                    <div class="vivio-tech__group-items">
                        @foreach ($techGroup['items'] as $item)
                            <span class="vivio-tech__item">{{ $item }}</span>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
