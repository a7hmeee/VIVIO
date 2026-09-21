<section class="vivio-hero" data-hero data-section="01">
    {{-- Three.js Canvas --}}
    <div class="vivio-hero__three" data-hero-three aria-hidden="true"></div>

    <div class="vivio-hero__bg" aria-hidden="true">
        <div class="vivio-hero__grid"></div>
        <div class="vivio-hero__glow"></div>
        <div class="vivio-hero__glow vivio-hero__glow--alt"></div>
    </div>

    <div class="vivio-container vivio-hero__layout">
        <div class="vivio-hero__content">
            <div class="vivio-hero__badge" data-hero-fade>
                <span class="vivio-hero__badge-dot"></span>
                <span class="vivio-hero__badge-text">VIVIO / DIGITAL TECHNOLOGY STUDIO</span>
            </div>

            <h1 class="vivio-hero-title">
                <span class="vivio-hero-line" data-hero-line><span>نحوّل أفكارك</span></span>
                <span class="vivio-hero-line vivio-hero-line--accent" data-hero-line><span>إلى أنظمة</span></span>
                <span class="vivio-hero-line vivio-hero-line--accent" data-hero-line><span>تحرّك عملك.</span></span>
            </h1>

            <p class="vivio-hero__desc" data-hero-fade>من المشكلة اللي معطّلة شغلك،<br>إلى نظام واضح يشتغل معك.</p>

            <div class="vivio-hero__actions" data-hero-fade>
                <a href="#start" class="vivio-button vivio-button--primary vivio-button--pill" data-magnetic>
                    <span>ابدأ مشروعك الآن</span>
                    <span aria-hidden="true">↗</span>
                </a>
                <a href="{{ route('projects') }}" class="vivio-button vivio-button--ghost vivio-button--pill" data-magnetic>
                    <span>شاهد أعمالنا</span>
                    <span class="vivio-hero__play-icon" aria-hidden="true">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                    </span>
                </a>
            </div>
        </div>

        <div class="vivio-hero__visual" data-hero-fade>
            <div class="vivio-hero__robot-glow" aria-hidden="true"></div>
            <img
                src="{{ asset('hero.png') }}"
                alt="VIVIO - كيان رقمي ذكي"
                class="vivio-hero__robot-img"
                width="680"
                height="800"
                loading="eager"
                decoding="async"
                data-robot
                data-robot-variant="hero"
            >
        </div>
    </div>

    {{-- Feature Strip --}}
    <div class="vivio-hero__features" data-hero-fade>
        <div class="vivio-container">
            <div class="vivio-hero__features-grid">
                <div class="vivio-hero__feature">
                    <div class="vivio-hero__feature-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
                    </div>
                    <h3 class="vivio-hero__feature-title">أمان وموثوقية</h3>
                    <p class="vivio-hero__feature-desc">حماية بياناتك وضمان استمرارية عملك.</p>
                </div>
                <div class="vivio-hero__feature">
                    <div class="vivio-hero__feature-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                    </div>
                    <h3 class="vivio-hero__feature-title">ذكاء اصطناعي</h3>
                    <p class="vivio-hero__feature-desc">أتمتة المهام وتحسين العمليات.</p>
                </div>
                <div class="vivio-hero__feature">
                    <div class="vivio-hero__feature-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                    </div>
                    <h3 class="vivio-hero__feature-title">تطوير مخصص</h3>
                    <p class="vivio-hero__feature-desc">حلول برمجية مرنّة قابلة للتوسع.</p>
                </div>
                <div class="vivio-hero__feature">
                    <div class="vivio-hero__feature-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
                    </div>
                    <h3 class="vivio-hero__feature-title">تصميم عصري</h3>
                    <p class="vivio-hero__feature-desc">واجهات ذكية وتجرية مستخدم استثنائية.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="vivio-hero__scroll" aria-hidden="true">
        <span class="vivio-hero__scroll-text">اكتشف المزيد</span>
        <span class="vivio-hero__scroll-line"></span>
    </div>

    {{-- VIVIO watermark --}}
    <div class="vivio-hero__watermark" aria-hidden="true">VIVIO</div>
</section>
