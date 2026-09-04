<section class="vivio-ticker" aria-label="VIVIO capabilities">
    <div class="vivio-ticker__row vivio-ticker__row--forward" data-ticker="forward">
        <div class="vivio-ticker__track">
            @foreach (['DIGITAL PRODUCTS', 'SOFTWARE SYSTEMS', 'AI INTEGRATION', 'WEB APPLICATIONS', 'BUSINESS AUTOMATION', 'REST APIs', 'E-COMMERCE', 'CUSTOM PLATFORMS'] as $word)
                <span class="vivio-ticker__item">{{ $word }}</span>
                <span class="vivio-ticker__sep" aria-hidden="true">✦</span>
            @endforeach
            @foreach (['DIGITAL PRODUCTS', 'SOFTWARE SYSTEMS', 'AI INTEGRATION', 'WEB APPLICATIONS', 'BUSINESS AUTOMATION', 'REST APIs', 'E-COMMERCE', 'CUSTOM PLATFORMS'] as $word)
                <span class="vivio-ticker__item">{{ $word }}</span>
                <span class="vivio-ticker__sep" aria-hidden="true">✦</span>
            @endforeach
        </div>
    </div>
    <div class="vivio-ticker__row vivio-ticker__row--reverse" data-ticker="reverse">
        <div class="vivio-ticker__track">
            @foreach (['LARAVEL', 'PHP', 'REACT', 'LIVEWIRE', 'NODE.JS', 'TYPESCRIPT', 'MYSQL', 'POSTGRESQL', 'MONGODB', 'TAILWIND', 'DOCKER', 'LINUX'] as $word)
                <span class="vivio-ticker__item vivio-ticker__item--accent">{{ $word }}</span>
                <span class="vivio-ticker__sep vivio-ticker__sep--line" aria-hidden="true">/</span>
            @endforeach
            @foreach (['LARAVEL', 'PHP', 'REACT', 'LIVEWIRE', 'NODE.JS', 'TYPESCRIPT', 'MYSQL', 'POSTGRESQL', 'MONGODB', 'TAILWIND', 'DOCKER', 'LINUX'] as $word)
                <span class="vivio-ticker__item vivio-ticker__item--accent">{{ $word }}</span>
                <span class="vivio-ticker__sep vivio-ticker__sep--line" aria-hidden="true">/</span>
            @endforeach
        </div>
    </div>
</section>
