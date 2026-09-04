<section class="vivio-why" id="why" data-section="08">
    <div class="vivio-container">
        <div class="vivio-section-head">
            <span class="vivio-overline">VIVIO / 08 · WHY US</span>
            <h2 class="vivio-serif">ما بنبني الشيء اللي طلبته فقط.<br><em>بنحاول نفهم ليش تحتاجه أصلًا.</em></h2>
        </div>

        <div class="vivio-why__list">
            @foreach ([
                ['num' => '01', 'en' => 'BUSINESS FIRST', 'ar' => 'الأعمال أولاً', 'desc' => 'نفهم الهدف قبل التقنية.'],
                ['num' => '02', 'en' => 'BUILT AROUND YOU', 'ar' => 'مبني حولك', 'desc' => 'النظام يتناسب مع طريقة شغلك.'],
                ['num' => '03', 'en' => 'SIMPLE ON THE SURFACE', 'ar' => 'بسيط من برا', 'desc' => 'التعقيد يكون خلف النظام، مش أمام المستخدم.'],
                ['num' => '04', 'en' => 'READY TO EVOLVE', 'ar' => 'قابل للتطوير', 'desc' => 'نبني بحيث يقدر يكبر معك.'],
            ] as $item)
                <div class="vivio-why__item" data-why>
                    <span class="vivio-why__num">{{ $item['num'] }}</span>
                    <div class="vivio-why__content">
                        <h3 class="vivio-serif">{{ $item['ar'] }}</h3>
                        <span class="vivio-why__en">{{ $item['en'] }}</span>
                        <p>{{ $item['desc'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
