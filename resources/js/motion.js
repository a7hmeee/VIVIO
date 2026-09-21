import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

/* ========================================
   VIVIO Motion System
   Reusable GSAP animation primitives
   ======================================== */

const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

/**
 * Reveal — fade + translateY on scroll
 */
export function reveal(selector, options = {}) {
    if (reducedMotion) return;
    const {
        y = 40,
        duration = 0.8,
        stagger = 0.1,
        delay = 0,
        start = 'top 85%',
        once = true,
    } = options;

    document.querySelectorAll(selector).forEach((el) => {
        gsap.from(el, {
            opacity: 0,
            y,
            duration,
            delay,
            ease: 'power3.out',
            scrollTrigger: { trigger: el, start, once },
        });
    });
}

/**
 * StaggerReveal — staggered children reveal
 */
export function staggerReveal(parentSelector, childSelector, options = {}) {
    if (reducedMotion) return;
    const {
        y = 30,
        duration = 0.7,
        stagger = 0.08,
        start = 'top 82%',
    } = options;

    document.querySelectorAll(parentSelector).forEach((parent) => {
        const children = parent.querySelectorAll(childSelector);
        if (!children.length) return;
        gsap.from(children, {
            opacity: 0,
            y,
            duration,
            stagger,
            ease: 'power3.out',
            scrollTrigger: { trigger: parent, start, once: true },
        });
    });
}

/**
 * Parallax — scroll-linked movement
 */
export function parallax(selector, options = {}) {
    if (reducedMotion) return;
    const {
        y = -50,
        start = 'top bottom',
        end = 'bottom top',
        scrub = 1,
    } = options;

    document.querySelectorAll(selector).forEach((el) => {
        gsap.to(el, {
            y,
            ease: 'none',
            scrollTrigger: { trigger: el, start, end, scrub },
        });
    });
}

/**
 * ScaleReveal — scale + opacity on scroll
 */
export function scaleReveal(selector, options = {}) {
    if (reducedMotion) return;
    const {
        scale = 0.95,
        duration = 1,
        start = 'top 80%',
    } = options;

    document.querySelectorAll(selector).forEach((el) => {
        gsap.from(el, {
            opacity: 0,
            scale,
            duration,
            ease: 'power3.out',
            scrollTrigger: { trigger: el, start, once: true },
        });
    });
}

/**
 * TextReveal — line-by-line text reveal
 */
export function textReveal(selector, options = {}) {
    if (reducedMotion) return;
    const {
        duration = 1,
        stagger = 0.15,
        delay = 0.3,
    } = options;

    const el = document.querySelector(selector);
    if (!el) return;

    const lines = el.querySelectorAll('[data-reveal-line] > span');
    if (!lines.length) return;

    gsap.set(lines, { yPercent: 115, opacity: 0 });
    gsap.to(lines, {
        yPercent: 0,
        opacity: 1,
        duration,
        stagger,
        delay,
        ease: 'power4.out',
    });
}

/**
 * MagneticElement — elements follow cursor
 */
export function magneticElements(selector, options = {}) {
    if (reducedMotion || window.matchMedia('(pointer: coarse)').matches) return;
    const { strength = 0.12 } = options;

    document.querySelectorAll(selector).forEach((el) => {
        el.addEventListener('pointermove', (e) => {
            const box = el.getBoundingClientRect();
            const x = (e.clientX - box.left - box.width / 2) * strength;
            const y = (e.clientY - box.top - box.height / 2) * strength;
            el.style.transform = `translate(${x}px, ${y}px)`;
        });
        el.addEventListener('pointerleave', () => {
            el.style.transform = '';
        });
    });
}

/**
 * ScrollProgress — animate width based on scroll
 */
export function scrollProgress(selector, options = {}) {
    if (reducedMotion) return;
    const {
        start = 'top 70%',
        end = 'bottom 40%',
        scrub = 0.6,
    } = options;

    document.querySelectorAll(selector).forEach((el) => {
        gsap.to(el, {
            width: '100%',
            ease: 'none',
            scrollTrigger: { trigger: el.parentElement || el, start, end, scrub },
        });
    });
}
