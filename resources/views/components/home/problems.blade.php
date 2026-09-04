<section class="vivio-problems" id="build" data-section="03" data-problems-section>
    <div class="vivio-problems__pin" data-problems-pin>
        <div class="vivio-container vivio-problems__inner">
            {{-- Intro block — always visible --}}
            <div class="vivio-problems__intro" data-problems-intro>
                <span class="vivio-overline">VIVIO / 03 · PROBLEM FIRST</span>
                <h2 class="vivio-serif vivio-problems__headline">
                    <span>مش لازم تعرف</span>
                    <span>الحل.</span>
                    <br>
                    <span class="vivio-problems__headline-accent">بس لازم تعرف</span>
                    <br>
                    <span class="vivio-problems__headline-accent">المشكلة.</span>
                </h2>
                <p class="vivio-problems__lead">لو واحدة من دول بتحصل في شركتك، غالبًا أقدر أساعدك.</p>
                <p class="vivio-problems__body">بنبدأ من المشكلة اللي معطّلة شغلك، نفهم كيف بتمشي العملية اليوم، وبعدها نختار الموقع أو الـSystem أو الـAutomation المناسب — مش العكس.</p>
            </div>

            {{-- Problems list — rows appear progressively --}}
            <div class="vivio-problems__list" data-problems-list>
                @foreach ([
                    ['num' => '01', 'problem' => 'موقعك موجود، بس ما بجيب النتيجة اللي بدك إياها.', 'category' => 'WEB / PRODUCT'],
                    ['num' => '02', 'problem' => 'فريقك بضيّع وقت على شغل ممكن يصير تلقائي.', 'category' => 'AUTOMATION'],
                    ['num' => '03', 'problem' => 'بياناتك موزعة بين Excel وWhatsApp وأكتر من مكان.', 'category' => 'SYSTEM / DATA'],
                    ['num' => '04', 'problem' => 'كل خطوة بسيطة بدها تدخل من شخص ثاني.', 'category' => 'WORKFLOW'],
                    ['num' => '05', 'problem' => 'شغلك كبر، بس النظام اللي بتديره فيه ما كبر معك.', 'category' => 'SCALE'],
                    ['num' => '06', 'problem' => 'عندك فكرة واضحة، بس مش عارف من وين تبدأ.', 'category' => 'DISCOVERY'],
                    ['num' => '07', 'problem' => 'عندك نظام شغال، بس صار يعيقك بدل ما يساعدك.', 'category' => 'MODERNIZATION'],
                    ['num' => '08', 'problem' => 'عندك بيانات كثيرة، بس لسه بتاخذ قراراتك بدون صورة واضحة.', 'category' => 'AI / ANALYTICS'],
                ] as $problem)
                    <article class="vivio-problem-row" data-problem-row tabindex="0">
                        <span class="vivio-problem-row__num">{{ $problem['num'] }}</span>
                        <div class="vivio-problem-row__content">
                            <h3 class="vivio-problem-row__statement">{{ $problem['problem'] }}</h3>
                        </div>
                        <div class="vivio-problem-row__meta">
                            <span class="vivio-problem-row__category">{{ $problem['category'] }}</span>
                        </div>
                    </article>
                @endforeach
            </div>

            {{-- Counter / progress --}}
            <div class="vivio-problems__progress" data-problems-progress>
                <span class="vivio-problems__progress-count" data-problems-count>00</span>
                <span class="vivio-problems__progress-label">PROBLEMS IDENTIFIED</span>
            </div>
        </div>
    </div>
</section>
