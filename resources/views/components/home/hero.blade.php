<section class="vivio-hero" data-hero data-section="01">
    <div class="vivio-hero__bg" aria-hidden="true">
        <div class="vivio-hero__grid"></div>
        <div class="vivio-hero__glow"></div>
        <div class="vivio-hero__glow vivio-hero__glow--alt"></div>
    </div>

    <div class="vivio-container vivio-hero__layout">
        <div class="vivio-hero__content">
            <div class="vivio-hero__meta" data-hero-fade>
                <span class="vivio-overline">VIVIO / DIGITAL TECHNOLOGY STUDIO</span>
                <span class="vivio-hero__tag">EST. 2024</span>
            </div>

            <h1 class="vivio-hero-title">
                <span class="vivio-hero-line" data-hero-line><span>نحوّل أفكارك</span></span>
                <span class="vivio-hero-line" data-hero-line><span>إلى أنظمة</span></span>
                <span class="vivio-hero-line vivio-hero-line--accent" data-hero-line><span>تُحرّك عملك.</span></span>
            </h1>

            <p class="vivio-hero__desc" data-hero-fade>من المشكلة اللي معطّلة شغلك،<br>إلى نظام واضح يشتغل معك.</p>

            <div class="vivio-hero__actions" data-hero-fade>
                <a href="#start" class="vivio-button vivio-button--primary" data-magnetic>ابدأ مشروعك ↗</a>
                <a href="{{ route('projects') }}" class="vivio-button vivio-button--ghost" data-magnetic>شوف شغلنا ↓</a>
            </div>
        </div>

        <div class="vivio-hero__visual" data-hero-fade>
            <x-robot.interactive variant="hero" size="large" />
        </div>
    </div>

    <div class="vivio-hero__scroll" aria-hidden="true">
        <span class="vivio-hero__scroll-line"></span>
        <span class="vivio-hero__scroll-text">SCROLL</span>
    </div>
</section>
