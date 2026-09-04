@props([
    'variant' => 'hero', // hero | intelligence | cta
    'size' => 'large',   // large | medium | small
])

@php
$sizes = [
    'large' => ['w' => 520, 'h' => 780, 'cls' => 'vivio-robot--large'],
    'medium' => ['w' => 280, 'h' => 420, 'cls' => 'vivio-robot--medium'],
    'small' => ['w' => 180, 'h' => 270, 'cls' => 'vivio-robot--small'],
];
$dim = $sizes[$size] ?? $sizes['large'];
@endphp

<figure class="vivio-robot {{ $dim['cls'] }} vivio-robot--{{ $variant }}" data-robot data-robot-variant="{{ $variant }}" aria-label="VIVIO Digital Entity">
    <div class="vivio-robot__environment" aria-hidden="true">
        <span class="vivio-robot__glow" aria-hidden="true"></span>
        <span class="vivio-robot__ring vivio-robot__ring--outer" aria-hidden="true"></span>
        <span class="vivio-robot__ring vivio-robot__ring--inner" aria-hidden="true"></span>
        <span class="vivio-robot__orbit" aria-hidden="true"></span>
    </div>

    <img
        src="{{ asset('robot.png') }}"
        alt="VIVIO - كيان رقمي ذكي"
        class="vivio-robot__asset"
        width="{{ $dim['w'] }}"
        height="{{ $dim['h'] }}"
        loading="{{ $variant === 'hero' ? 'eager' : 'lazy' }}"
        decoding="async"
    >

    @if ($variant === 'hero')
        <span class="vivio-robot__label vivio-robot__label--top" aria-hidden="true"><i></i> SYSTEM ONLINE</span>
        <span class="vivio-robot__label vivio-robot__label--right" aria-hidden="true"><i></i> AI ACTIVE</span>
        <span class="vivio-robot__label vivio-robot__label--bottom" aria-hidden="true">PROCESSING</span>
        <span class="vivio-robot__meta" aria-hidden="true">VIVIO / 001</span>
    @elseif ($variant === 'intelligence')
        <span class="vivio-robot__label vivio-robot__label--top" aria-hidden="true"><i></i> AI ACTIVE</span>
        <span class="vivio-robot__label vivio-robot__label--right" aria-hidden="true"><i></i> SYSTEM ONLINE</span>
        <span class="vivio-robot__label vivio-robot__label--bottom" aria-hidden="true"><i></i> PROCESSING</span>
    @elseif ($variant === 'cta')
        <span class="vivio-robot__label vivio-robot__label--top" aria-hidden="true"><i></i> SYSTEM READY</span>
        <span class="vivio-robot__meta" aria-hidden="true">VIVIO / 001</span>
    @endif
</figure>
