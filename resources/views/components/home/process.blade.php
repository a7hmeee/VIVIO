<section class="vivio-process-section" id="process" data-section="06">
    <div class="vivio-container">
        <div class="vivio-section-head">
            <span class="vivio-overline">VIVIO / 06 · PROCESS</span>
            <h2 class="vivio-serif">ما بنرمي كود<br><em>ونستنى النتيجة.</em></h2>
        </div>

        <div class="vivio-process__track" data-process-track>
            @foreach ([
                ['01', 'DISCOVER', 'نفهم المشكلة، الناس، والعملية الحالية.'],
                ['02', 'DESIGN', 'نرتب التجربة قبل ما نبدأ نبني.'],
                ['03', 'BUILD', 'نحوّل الحل إلى نظام حقيقي قابل للاستخدام.'],
                ['04', 'LAUNCH', 'نطلق، نراقب، ونحسّن.'],
            ] as [$number, $stage, $text])
                <div class="vivio-process__step" data-process-step>
                    <span class="vivio-process__number">{{ $number }}</span>
                    <strong>{{ $stage }}</strong>
                    <p>{{ $text }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
