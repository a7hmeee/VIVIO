@props([
    'teamMembers' => collect(),
    'contactEmail' => 'hello@vivio.studio',
    'contactPhone' => null,
    'contactWhatsapp' => null,
    'contactRoute' => '#',
])

@if ($teamMembers->isNotEmpty())
    <section class="vivio-team" id="team" data-section="09">
        <div class="vivio-container">
            <div class="vivio-section-head">
                <span class="vivio-overline">VIVIO / 09 · TEAM</span>
                <h2 class="vivio-serif">وراء كل System،<br><em>في ناس بتفكر فيه.</em></h2>
            </div>

            <div class="vivio-team__grid">
                @foreach ($teamMembers as $member)
                    <article class="vivio-team-card" data-team-card>
                        <div class="vivio-team-card__photo">
                            @if ($member->photo)
                                <img src="{{ asset('storage/'.$member->photo) }}" alt="{{ $member->name }}" loading="lazy">
                            @else
                                <div class="vivio-team-card__initial">{{ mb_substr($member->name, 0, 1) }}</div>
                            @endif
                        </div>
                        <div class="vivio-team-card__info">
                            <span class="vivio-team-card__role">{{ $member->role }}</span>
                            <h3 class="vivio-serif">{{ $member->name }}</h3>
                            @if ($member->specialty)
                                <p>{{ $member->specialty }}</p>
                            @endif
                            @if ($member->skills)
                                <div class="vivio-team-card__skills">
                                    @foreach (array_slice($member->skills, 0, 4) as $skill)
                                        <span>{{ $skill }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endif

<section class="vivio-final" id="start" data-section="10">
    <div class="vivio-container vivio-final__layout">
        <div class="vivio-final__copy">
            <span class="vivio-overline">VIVIO / NEXT BUILD</span>
            <h2 class="vivio-serif">عندك مشكلة؟<br><em>خلينا نحوّلها إلى نظام.</em></h2>
            <p class="vivio-final__desc">احكيلنا شو اللي معطّل شغلك، ومن هناك بنبدأ.</p>
            <div class="vivio-final__actions">
                <a href="#contact" class="vivio-button vivio-button--primary" data-magnetic>ابدأ مشروعك ↗</a>
                <a href="{{ route('projects') }}" class="vivio-button vivio-button--ghost" data-magnetic>شوف شغلنا</a>
            </div>
        </div>
        <div class="vivio-final__visual">
            <x-robot.interactive variant="cta" size="small" />
        </div>
    </div>
</section>

<section class="vivio-form" id="contact">
    <div class="vivio-container vivio-form__layout">
        <div class="vivio-form__intro">
            <span class="vivio-overline">VIVIO / START A PROJECT</span>
            <h2 class="vivio-serif">ابدأ<br><em>مشروعك.</em></h2>
            <p class="vivio-form__desc">املأ التفاصيل وسنعود إليك بأقرب وقت.</p>

            @if ($contactPhone)
                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $contactPhone) }}" class="vivio-form__contact" dir="ltr">{{ $contactPhone }}</a>
            @endif
            @if ($contactWhatsapp)
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contactWhatsapp) }}" target="_blank" rel="noopener" class="vivio-form__contact" dir="ltr">{{ $contactWhatsapp }}</a>
            @endif
            <a href="mailto:{{ $contactEmail }}" class="vivio-form__contact" dir="ltr">{{ $contactEmail }}</a>
        </div>

        <div class="vivio-form__panel">
            @if (session('contact_success'))
                <div class="vivio-form__success" role="status">
                    <span>✓</span>
                    <p>{{ session('contact_success') }}</p>
                </div>
            @endif
            <form method="POST" action="{{ $contactRoute }}" novalidate>
                @csrf
                @if ($errors->any())
                    <div class="vivio-form__error" role="alert">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <div class="vivio-form__row">
                    <div class="vivio-form__field">
                        <label for="lead-name">الاسم</label>
                        <input id="lead-name" name="name" type="text" value="{{ old('name') }}" required autocomplete="name">
                    </div>
                    <div class="vivio-form__field">
                        <label for="lead-phone">رقم الهاتف</label>
                        <input id="lead-phone" name="phone" type="tel" value="{{ old('phone') }}" autocomplete="tel" dir="ltr">
                    </div>
                </div>
                <div class="vivio-form__field">
                    <label for="lead-email">البريد الإلكتروني</label>
                    <input id="lead-email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email" dir="ltr">
                </div>
                <div class="vivio-form__field">
                    <label for="lead-type">نوع المشروع</label>
                    <select id="lead-type" name="project_type" required>
                        <option value="" disabled {{ old('project_type') ? '' : 'selected' }}>اختر نوع المشروع</option>
                        @foreach (['Website', 'Digital System', 'E-Commerce', 'Automation', 'AI', 'Other'] as $type)
                            <option value="{{ $type }}" {{ old('project_type') === $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="vivio-form__field">
                    <label for="lead-message">تفاصيل المشروع</label>
                    <textarea id="lead-message" name="message" rows="4" required>{{ old('message') }}</textarea>
                </div>
                <button type="submit" class="vivio-form__submit" data-magnetic>
                    أرسل تفاصيل المشروع
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                        <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</section>
