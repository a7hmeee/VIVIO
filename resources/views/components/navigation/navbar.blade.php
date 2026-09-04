@props([
    'transparent' => false,
])

<header class="vivio-nav" data-nav>
    <div class="vivio-nav__inner">
        <a href="{{ route('home') }}" class="vivio-brand" aria-label="VIVIO home">
            <img src="{{ asset('images/vivio-logo.svg') }}" alt="VIVIO" width="128" height="26">
        </a>
        <nav class="vivio-nav__links" data-nav-links aria-label="القائمة الرئيسية">
            <a href="{{ route('home') }}#build" data-cursor="SERVICES">الخدمات</a>
            <a href="{{ route('projects') }}" data-cursor="WORK">أعمالنا</a>
            <a href="{{ route('home') }}#process" data-cursor="PROCESS">عملية العمل</a>
            <a href="{{ route('home') }}#why" data-cursor="WHY">عن فيفيو</a>
        </nav>
        <div class="vivio-nav__actions">
            <span class="vivio-status" aria-hidden="true"><i></i> SYSTEM ONLINE</span>
            <a href="{{ route('home') }}#contact" class="vivio-nav__cta" data-magnetic data-cursor="START">ابدأ مشروعك <span>→</span></a>
            <button type="button" class="vivio-menu-toggle" data-menu-toggle aria-expanded="false" aria-controls="vivio-mobile-menu" aria-label="فتح القائمة">
                <span></span><span></span>
            </button>
        </div>
    </div>
    <div class="vivio-mobile-menu" id="vivio-mobile-menu" data-mobile-menu aria-hidden="true">
        <span class="vivio-overline">VIVIO / NAVIGATION</span>
        <nav>
            <a href="{{ route('home') }}#build">الخدمات <small>01</small></a>
            <a href="{{ route('projects') }}">أعمالنا <small>02</small></a>
            <a href="{{ route('home') }}#process">عملية العمل <small>03</small></a>
            <a href="{{ route('home') }}#why">عن فيفيو <small>04</small></a>
            <a href="{{ route('home') }}#contact">ابدأ مشروعك <small>05</small></a>
        </nav>
        <span class="vivio-mobile-menu__footer">VIVIO / DIGITAL TECHNOLOGY STUDIO</span>
    </div>
</header>
