<x-layout.base title="VIVIO — نحوّل الأفكار إلى أنظمة" description="VIVIO تبني الأنظمة الرقمية، البرمجيات المخصصة، حلول الذكاء الاصطناعي، والأتمتة للفرق الطموحة.">
    <main class="vivio-world">

        @php
            $contactEmail = \Illuminate\Support\Facades\Schema::hasTable('settings')
                ? \App\Models\Setting::get('contact_email', $contactEmail ?? 'hello@vivio.studio')
                : ($contactEmail ?? 'hello@vivio.studio');
            $contactPhone = \Illuminate\Support\Facades\Schema::hasTable('settings') ? \App\Models\Setting::get('phone') : null;
            $contactWhatsapp = \Illuminate\Support\Facades\Schema::hasTable('settings') ? \App\Models\Setting::get('whatsapp') : null;
            $contactRoute = \Illuminate\Support\Facades\Route::has('contact.submit') ? route('contact.submit') : '#';

            $projectTechnologies = $projects->pluck('technologies')
                ->filter()
                ->flatten()
                ->unique()
                ->values();
        @endphp

        {{-- 01 Hero --}}
        <x-home.hero />

        {{-- 02 Brand Ticker --}}
        <x-home.ticker />

        {{-- 03 Problem / What We Do --}}
        <x-home.problems />

        {{-- 04 Problem → System --}}
        <section class="vivio-transformation" id="transform" data-section="04">
            <div class="vivio-container">
                <div class="vivio-section-head vivio-section-head--row">
                    <div>
                        <span class="vivio-overline">VIVIO / 04 · TRANSFORMATION</span>
                        <h2 class="vivio-serif">مش كل مشكلة بدها Software.<br><em>ومش كل Software بحل المشكلة.</em></h2>
                    </div>
                </div>

                <div class="vivio-transformation__grid" data-transformation>
                    <div class="vivio-transformation__column vivio-transformation__column--before">
                        <span class="vivio-transformation__label">BEFORE</span>
                        <div class="vivio-transformation__nodes">
                            @foreach (['Excel', 'WhatsApp', 'Manual Work', 'Scattered Data', 'Repeated Tasks', 'No Clear Workflow'] as $node)
                                <span class="vivio-transformation__node vivio-transformation__node--warn">{{ $node }}</span>
                            @endforeach
                        </div>
                    </div>

                    <div class="vivio-transformation__arrow" aria-hidden="true">
                        <span class="vivio-transformation__arrow-line"></span>
                        <span class="vivio-transformation__arrow-core">VIVIO</span>
                        <span class="vivio-transformation__arrow-line"></span>
                    </div>

                    <div class="vivio-transformation__column vivio-transformation__column--after">
                        <span class="vivio-transformation__label">AFTER</span>
                        <div class="vivio-transformation__nodes">
                            @foreach (['One System', 'Clear Workflow', 'Automation', 'Centralized Data', 'Visibility', 'Scalable Operations'] as $node)
                                <span class="vivio-transformation__node vivio-transformation__node--ok">{{ $node }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <p class="vivio-transformation__closing">إحنا بنحدد المشكلة أولًا. وبعدين نبني الشيء اللي فعلًا تحتاجه.</p>
            </div>
        </section>

        {{-- 05 Selected Work --}}
        <x-home.selected-work :projects="$projects" />

        {{-- 06 Process --}}
        <x-home.process />

        {{-- 07 Technology --}}
        <x-home.technology :technologies="$projectTechnologies" />

        {{-- 08 Why Vivio --}}
        <x-home.why />

        {{-- 09 Team + 10 CTA + 11 Contact --}}
        <x-home.team-cta
            :teamMembers="$teamMembers"
            :contactEmail="$contactEmail"
            :contactPhone="$contactPhone"
            :contactWhatsapp="$contactWhatsapp"
            :contactRoute="$contactRoute"
        />

    </main>
</x-layout.base>
