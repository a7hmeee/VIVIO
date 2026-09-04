import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import Lenis from 'lenis';

/* ========================================
   VIVIO Frontend Entry Point
   Premium Arabic Digital Technology Studio
   ======================================== */

gsap.registerPlugin(ScrollTrigger);

const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
const coarsePointer = window.matchMedia('(pointer: coarse)').matches;

/* ----------------------------------------
   Lenis Smooth Scroll
   ---------------------------------------- */
const lenis = reducedMotion ? null : new Lenis({
    duration: 1.15,
    easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
    smoothWheel: true,
    touchMultiplier: 1.6,
});

lenis?.on('scroll', ScrollTrigger.update);
gsap.ticker.add((time) => lenis?.raf(time * 1000));
gsap.ticker.lagSmoothing(0);

window.VivioScroll = {
    scrollTo: (target, options = {}) => lenis?.scrollTo(target, options),
    stop: () => lenis?.stop(),
    start: () => lenis?.start(),
    resize: () => lenis?.resize(),
};

gsap.defaults({ ease: 'power3.out', duration: 0.8 });
ScrollTrigger.defaults({ toggleActions: 'play none none reverse' });

/* ----------------------------------------
   Hero entrance — Vivio signature motion
   ---------------------------------------- */
function initHero() {
    const hero = document.querySelector('[data-hero]');
    if (!hero) return;

    if (reducedMotion) {
        hero.querySelectorAll('[data-hero-line] > span').forEach(s => s.style.transform = 'none');
        hero.querySelectorAll('[data-hero-fade]').forEach(s => s.style.opacity = '1');
        return;
    }

    const lines = hero.querySelectorAll('[data-hero-line] > span');
    const fades = hero.querySelectorAll('[data-hero-fade]');
    const robot = hero.querySelector('[data-robot]');
    const robotAsset = robot?.querySelector('.vivio-robot__asset');
    const robotLabels = hero.querySelectorAll('.vivio-robot__label, .vivio-robot__meta');
    const robotRings = hero.querySelectorAll('.vivio-robot__ring, .vivio-robot__orbit');
    const meta = hero.querySelector('.vivio-hero__meta');
    const title = hero.querySelector('.vivio-hero-title');
    const grid = hero.querySelector('.vivio-hero__grid');
    const scroll = hero.querySelector('.vivio-hero__scroll');

    /* — Initial states — */
    gsap.set(lines, { yPercent: 115, opacity: 0 });
    gsap.set(fades, { opacity: 0, y: 16 });
    gsap.set(robotAsset, { x: 40, y: 30, scale: .92, opacity: 0, rotate: 2 });
    gsap.set(robotLabels, { opacity: 0, x: -8 });
    gsap.set(robotRings, { scale: .7, opacity: 0 });
    gsap.set(grid, { opacity: 0 });
    gsap.set(scroll, { opacity: 0, y: -12 });

    /* — Entrance timeline — */
    const tl = gsap.timeline({ delay: .3 });

    /* Phase 1: Grid fades in — the system activates */
    tl.to(grid, { opacity: .18, duration: 1.4, ease: 'power2.out' }, 0);

    /* Phase 2: Robot begins assembling — displaced, then locks */
    tl.to(robotAsset, {
        x: 0, y: 0, scale: 1, opacity: 1, rotate: 0,
        duration: 1.8,
        ease: 'power3.out',
    }, .2);

    tl.to(robotRings, {
        scale: 1, opacity: 1,
        duration: 1.4,
        stagger: .15,
        ease: 'power2.out',
    }, .5);

    tl.to(robotLabels, {
        opacity: 1, x: 0,
        duration: .8,
        stagger: .12,
        ease: 'power3.out',
    }, 1.2);

    /* Phase 3: Headline assembles — each line locks into position */
    lines.forEach((line, i) => {
        tl.to(line, {
            yPercent: 0,
            opacity: 1,
            duration: 1,
            ease: 'power4.out',
        }, .5 + (i * .18));
    });

    /* Phase 4: Supporting content fades in */
    tl.to(fades, {
        opacity: 1,
        y: 0,
        duration: .8,
        stagger: .1,
        ease: 'power3.out',
    }, '-=.4');

    /* Phase 5: Scroll indicator appears */
    tl.to(scroll, {
        opacity: 1,
        y: 0,
        duration: .7,
        ease: 'power2.out',
    }, '-=.3');

    /* — Robot idle — subtle, intentional — */
    if (robotAsset) {
        gsap.to(robotAsset, {
            y: -6,
            duration: 3.5,
            repeat: -1,
            yoyo: true,
            ease: 'sine.inOut',
            delay: 2.5,
        });
        gsap.to(robotAsset, {
            scale: 1.015,
            duration: 4,
            repeat: -1,
            yoyo: true,
            ease: 'sine.inOut',
            delay: 2.8,
        });

        /* Robot mouse parallax — desktop only */
        if (!coarsePointer) {
            let tx = 0, ty = 0;
            robot.addEventListener('pointermove', (e) => {
                const r = robot.getBoundingClientRect();
                tx = ((e.clientX - r.left) / r.width - .5) * 10;
                ty = ((e.clientY - r.top) / r.height - .5) * 6;
            }, { passive: true });
            robot.addEventListener('pointerleave', () => { tx = 0; ty = 0; });
            gsap.ticker.add(() => {
                gsap.set(robotAsset, {
                    x: gsap.utils.interpolate(
                        gsap.getProperty(robotAsset, 'x') || 0, tx, .06
                    ),
                });
            });
        }
    }

    /* — Scroll interaction — Hero transforms, not scrolls — */
    if (title && robot) {
        const scrollTl = gsap.timeline({
            scrollTrigger: {
                trigger: hero,
                start: 'top top',
                end: 'bottom top',
                scrub: 1.2,
            },
        });

        /* Headline compresses on scroll */
        scrollTl.to(title, {
            scale: .88,
            y: -40,
            opacity: .3,
            ease: 'none',
        }, 0);

        /* Robot moves deeper on different plane */
        scrollTl.to(robotAsset, {
            y: -80,
            scale: .85,
            ease: 'none',
        }, 0);

        /* Supporting text exits faster */
        scrollTl.to(fades, {
            y: -30,
            opacity: 0,
            ease: 'none',
        }, 0);

        /* Grid fades out */
        scrollTl.to(grid, {
            opacity: 0,
            ease: 'none',
        }, 0);

        /* Scroll indicator fades */
        scrollTl.to(scroll, {
            opacity: 0,
            y: -20,
            ease: 'none',
        }, 0);
    }
}

/* ----------------------------------------
   Robot ambient motion (PNG)
   ---------------------------------------- */
function initRobotMotion() {
    const robots = document.querySelectorAll('[data-robot]');
    if (!robots.length) return;

    robots.forEach((robot) => {
        const asset = robot.querySelector('.vivio-robot__asset');
        if (!asset) return;

        if (!reducedMotion) {
            // Subtle continuous float
            gsap.to(asset, {
                y: -10,
                duration: 2.8,
                repeat: -1,
                yoyo: true,
                ease: 'sine.inOut',
            });

            // Subtle scale breathing
            gsap.to(asset, {
                scale: 1.02,
                duration: 3.2,
                repeat: -1,
                yoyo: true,
                ease: 'sine.inOut',
            });

            // Mouse parallax (desktop only)
            if (!coarsePointer && robot.dataset.robotVariant === 'hero') {
                let targetX = 0;
                let targetY = 0;
                robot.addEventListener('pointermove', (event) => {
                    const box = robot.getBoundingClientRect();
                    targetX = ((event.clientX - box.left) / box.width - .5) * 12;
                    targetY = ((event.clientY - box.top) / box.height - .5) * 8;
                }, { passive: true });
                robot.addEventListener('pointerleave', () => { targetX = 0; targetY = 0; });

                gsap.ticker.add(() => {
                    gsap.set(asset, {
                        x: gsap.utils.interpolate(gsap.getProperty(asset, 'x') || 0, targetX, .08),
                    });
                });
            }
        }

        // Reveal on scroll
        ScrollTrigger.create({
            trigger: robot,
            start: 'top 80%',
            onEnter: () => gsap.fromTo(robot, { opacity: 0, y: 40 }, { opacity: 1, y: 0, duration: 1, ease: 'power3.out' }),
            once: true,
        });
    });
}

/* ----------------------------------------
   Capabilities hover
   ---------------------------------------- */
function initCapabilities() {
    const cards = document.querySelectorAll('[data-service-card]');
    if (!cards.length) return;

    cards.forEach((card) => {
        card.addEventListener('mouseenter', () => {
            cards.forEach((c) => c.classList.toggle('is-active', c === card));
        });
        card.addEventListener('focus', () => {
            cards.forEach((c) => c.classList.toggle('is-active', c === card));
        });
    });
}

/* ----------------------------------------
   Problem steps reveal
   ---------------------------------------- */
function initProblems() {
    const steps = document.querySelectorAll('[data-problem-step]');
    if (!steps.length) return;

    if (reducedMotion) {
        steps.forEach((step) => step.classList.add('is-active'));
        return;
    }

    steps.forEach((step, index) => {
        gsap.from(step, {
            opacity: 0,
            y: 30,
            duration: .7,
            delay: index * .1,
            scrollTrigger: { trigger: step.parentElement, start: 'top 75%', once: true },
        });
    });
}

/* ----------------------------------------
   Chaos → system field
   ---------------------------------------- */
function initSystemField() {
    const field = document.querySelector('[data-chaos]');
    if (!field) return;
    if (reducedMotion) { field.classList.add('is-active'); return; }
    ScrollTrigger.create({
        trigger: field,
        start: 'top 70%',
        onEnter: () => field.classList.add('is-active'),
        onLeaveBack: () => field.classList.remove('is-active'),
    });
}

/* ----------------------------------------
   Process timeline
   ---------------------------------------- */
function initProcess() {
    const track = document.querySelector('[data-process-track]');
    if (!track) return;
    const steps = track.querySelectorAll('[data-process-step]');
    const progress = track.querySelector('[data-process-progress]');
    if (reducedMotion) {
        steps.forEach((step) => step.classList.add('is-active'));
        return;
    }
    steps.forEach((step, index) => {
        ScrollTrigger.create({
            trigger: step,
            start: 'top 72%',
            onEnter: () => step.classList.add('is-active'),
            onLeaveBack: () => { if (index > 0) step.classList.remove('is-active'); },
        });
    });
    if (progress) {
        gsap.to(progress, {
            width: '100%',
            ease: 'none',
            scrollTrigger: { trigger: track, start: 'top 70%', end: 'bottom 40%', scrub: .6 },
        });
    }
}

/* ----------------------------------------
   Technology system — scroll reveal
   ---------------------------------------- */
function initTech() {
    if (reducedMotion) return;
    const groups = document.querySelectorAll('[data-tech-group]');
    if (!groups.length) return;
    groups.forEach((group, index) => {
        const items = group.querySelectorAll('.vivio-tech__item');
        const label = group.querySelector('.vivio-tech__label');
        gsap.from(group, {
            opacity: 0,
            x: -30,
            duration: .8,
            delay: index * .06,
            scrollTrigger: { trigger: group, start: 'top 88%' },
        });
        if (items.length) {
            gsap.from(items, {
                opacity: 0,
                y: 20,
                duration: .5,
                stagger: .04,
                delay: index * .06 + .1,
                scrollTrigger: { trigger: group, start: 'top 85%' },
            });
        }
    });
}

/* ----------------------------------------
   Why VIVIO
   ---------------------------------------- */
function initWhy() {
    if (reducedMotion) return;
    document.querySelectorAll('[data-why]').forEach((item) => {
        gsap.from(item, {
            opacity: 0,
            y: 50,
            duration: .9,
            scrollTrigger: { trigger: item, start: 'top 80%' },
        });
    });
}

/* ----------------------------------------
   Section reveals
   ---------------------------------------- */
function initSectionReveals() {
    if (reducedMotion) return;
    document.querySelectorAll('.vivio-section-head').forEach((head) => {
        gsap.from(head.children, {
            opacity: 0,
            y: 30,
            duration: .8,
            stagger: .1,
            scrollTrigger: { trigger: head, start: 'top 82%' },
        });
    });
}

/* ----------------------------------------
   Project Carousel
   ---------------------------------------- */
function initProjectCarousel() {
    const root = document.querySelector('[data-projects-carousel]');
    if (!root) return;

    const slides = root.querySelectorAll('.vpc__slide');
    const navItems = root.querySelectorAll('[data-carousel-nav]');
    const prevBtn = root.querySelector('[data-carousel-prev]');
    const nextBtn = root.querySelector('[data-carousel-next]');
    const currentEl = root.querySelector('[data-carousel-current]');
    const total = slides.length;
    if (total < 2) return;

    let active = 0;
    let animating = false;

    function goTo(index) {
        if (index === active || animating) return;
        animating = true;

        const outSlide = slides[active];
        const inSlide = slides[index];

        // Deactivate old
        outSlide.classList.remove('is-active');
        outSlide.setAttribute('inert', '');
        navItems[active]?.setAttribute('aria-selected', 'false');
        navItems[active]?.classList.remove('is-active');

        // Activate new
        inSlide.removeAttribute('inert');
        inSlide.classList.add('is-active');
        navItems[index]?.setAttribute('aria-selected', 'true');
        navItems[index]?.classList.add('is-active');

        // Animate with GSAP
        if (!reducedMotion && window.gsap) {
            const info = inSlide.querySelector('.vpc__info');
            const devices = inSlide.querySelector('.vpc__devices');

            gsap.fromTo(info,
                { opacity: 0, x: 30 },
                { opacity: 1, x: 0, duration: .5, ease: 'power3.out' }
            );
            gsap.fromTo(devices,
                { opacity: 0, scale: .97 },
                { opacity: 1, scale: 1, duration: .55, ease: 'power3.out', delay: .05 }
            );
        }

        active = index;
        if (currentEl) currentEl.textContent = String(active + 1).padStart(2, '0');

        // Update nav scroll
        navItems[active]?.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });

        setTimeout(() => { animating = false; }, 520);
    }

    prevBtn?.addEventListener('click', () => goTo((active - 1 + total) % total));
    nextBtn?.addEventListener('click', () => goTo((active + 1) % total));

    navItems.forEach((item) => {
        item.addEventListener('click', () => {
            goTo(parseInt(item.dataset.carouselNav, 10));
        });
    });

    // Keyboard
    root.setAttribute('tabindex', '0');
    root.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') { e.preventDefault(); goTo((active - 1 + total) % total); }
        if (e.key === 'ArrowRight') { e.preventDefault(); goTo((active + 1) % total); }
    });
}

/* ----------------------------------------
   Navigation
   ---------------------------------------- */
function initNavigation() {
    const nav = document.querySelector('[data-nav]');
    const toggle = document.querySelector('[data-menu-toggle]');
    const menu = document.querySelector('[data-mobile-menu]');
    if (!nav || !toggle || !menu) return;
    const update = () => nav.classList.toggle('is-scrolled', window.scrollY > 40);
    update();
    window.addEventListener('scroll', update, { passive: true });
    toggle.addEventListener('click', () => {
        const open = toggle.getAttribute('aria-expanded') === 'true';
        toggle.setAttribute('aria-expanded', String(!open));
        menu.setAttribute('aria-hidden', String(open));
        menu.classList.toggle('is-open', !open);
        document.body.classList.toggle('vivio-menu-open', !open);
    });
    menu.querySelectorAll('a').forEach((link) => link.addEventListener('click', () => {
        toggle.setAttribute('aria-expanded', 'false');
        menu.setAttribute('aria-hidden', 'true');
        menu.classList.remove('is-open');
        document.body.classList.remove('vivio-menu-open');
    }));
}

/* ----------------------------------------
   Transformation reveal
   ---------------------------------------- */
function initTransformation() {
    const grid = document.querySelector('[data-transformation]');
    if (!grid) return;
    if (reducedMotion) return;
    const columns = grid.querySelectorAll('.vivio-transformation__column');
    gsap.from(columns, {
        opacity: 0,
        y: 50,
        duration: .9,
        stagger: .2,
        scrollTrigger: { trigger: grid, start: 'top 75%' },
    });
}

/* ----------------------------------------
   Work project reveals
   ---------------------------------------- */
function initWorkReveals() {
    if (reducedMotion) return;
    document.querySelectorAll('[data-work-project]').forEach((project, index) => {
        const visual = project.querySelector('.vivio-work-project__visual');
        const info = project.querySelector('.vivio-work-project__info');

        gsap.from(project, {
            opacity: 0,
            y: 80,
            duration: 1,
            scrollTrigger: { trigger: project, start: 'top 82%' },
        });

        if (visual) {
            gsap.from(visual, {
                opacity: 0,
                scale: .96,
                duration: 1.1,
                delay: .1,
                scrollTrigger: { trigger: project, start: 'top 80%' },
            });
        }

        if (info) {
            gsap.from(info.children, {
                opacity: 0,
                y: 30,
                duration: .8,
                stagger: .08,
                delay: .2 + (index * .05),
                scrollTrigger: { trigger: project, start: 'top 78%' },
            });
        }
    });
}

/* ----------------------------------------
   Team cards reveal
   ---------------------------------------- */
function initTeamReveals() {
    if (reducedMotion) return;
    document.querySelectorAll('[data-team-card]').forEach((card, index) => {
        gsap.from(card, {
            opacity: 0,
            y: 50,
            duration: .8,
            delay: index * .12,
            scrollTrigger: { trigger: card, start: 'top 85%' },
        });
    });
}

/* ----------------------------------------
   Problem section — scroll storytelling
   ---------------------------------------- */
function initProblemRows() {
    const section = document.querySelector('[data-problems-section]');
    const pin = document.querySelector('[data-problems-pin]');
    const rows = document.querySelectorAll('[data-problem-row]');
    const counter = document.querySelector('[data-problems-count]');
    if (!section || !rows.length) return;

    /* SAFE: content is VISIBLE by default. Never set opacity: 0 via CSS.
       GSAP controls the reveal, but if it fails, content stays visible. */

    if (reducedMotion) {
        /* No animation — everything visible */
        return;
    }

    const isMobile = window.matchMedia('(max-width: 1024px)').matches;

    if (!isMobile) {
        /* Desktop: pin section, scrub through problems */
        const pinHeight = pin.offsetHeight;
        const scrollDistance = pinHeight * 1.5;

        const tl = gsap.timeline({
            scrollTrigger: {
                trigger: section,
                start: 'top top',
                end: () => `+=${scrollDistance}`,
                pin: pin,
                scrub: .8,
                anticipatePin: 1,
                onUpdate: (self) => {
                    /* Update counter */
                    if (counter) {
                        const progress = self.progress;
                        const count = Math.min(Math.ceil(progress * rows.length), rows.length);
                        counter.textContent = String(count).padStart(2, '0');
                    }
                },
            },
        });

        /* Progressively reveal each row */
        rows.forEach((row, i) => {
            const rowStart = i / rows.length;
            const rowEnd = (i + 1) / rows.length;

            tl.fromTo(row, {
                opacity: 0,
                y: 30,
                clipPath: 'inset(0 0 100% 0)',
            }, {
                opacity: 1,
                y: 0,
                clipPath: 'inset(0 0 0% 0)',
                duration: rowEnd - rowStart,
                ease: 'power2.out',
            }, rowStart);
        });
    } else {
        /* Mobile: no pin, simple scroll reveal */
        rows.forEach((row, i) => {
            gsap.fromTo(row,
                { opacity: 0, y: 20 },
                {
                    opacity: 1,
                    y: 0,
                    duration: .6,
                    scrollTrigger: {
                        trigger: row,
                        start: 'top 90%',
                    },
                }
            );
        });
    }

    /* Hover / focus interaction */
    rows.forEach((row) => {
        row.addEventListener('mouseenter', () => {
            rows.forEach((r) => r.classList.toggle('is-active', r === row));
        });
        row.addEventListener('mouseleave', () => {
            rows.forEach((r) => r.classList.remove('is-active'));
        });
        row.addEventListener('focus', () => {
            rows.forEach((r) => r.classList.toggle('is-active', r === row));
        });
        row.addEventListener('blur', () => {
            rows.forEach((r) => r.classList.remove('is-active'));
        });
    });
}

/* ----------------------------------------
   Cursor, magnetic buttons
   ---------------------------------------- */
function initCursor() {
    if (coarsePointer) return;
    const cursor = document.createElement('div');
    cursor.className = 'vivio-cursor';
    cursor.innerHTML = '<span></span>';
    document.body.append(cursor);
    window.addEventListener('pointermove', (event) => {
        cursor.style.transform = `translate3d(${event.clientX}px, ${event.clientY}px, 0)`;
    }, { passive: true });
    document.querySelectorAll('[data-cursor]').forEach((el) => {
        el.addEventListener('mouseenter', () => {
            cursor.classList.add('is-label');
            cursor.querySelector('span').textContent = el.dataset.cursor;
        });
        el.addEventListener('mouseleave', () => cursor.classList.remove('is-label'));
    });
}

function initMagnetic() {
    if (coarsePointer || reducedMotion) return;
    document.querySelectorAll('[data-magnetic]').forEach((el) => {
        el.addEventListener('pointermove', (event) => {
            const box = el.getBoundingClientRect();
            el.style.transform = `translate(${(event.clientX - box.left - box.width / 2) * .12}px, ${(event.clientY - box.top - box.height / 2) * .12}px)`;
        });
        el.addEventListener('pointerleave', () => { el.style.transform = ''; });
    });
}

/* ----------------------------------------
   Boot
   ---------------------------------------- */
document.addEventListener('DOMContentLoaded', () => {
    initNavigation();
    initHero();
    initRobotMotion();
    initCapabilities();
    initProblems();
    initSystemField();
    initProcess();
    initTech();
    initWhy();
    initSectionReveals();
    initProjectCarousel();
    initTransformation();
    initWorkReveals();
    initTeamReveals();
    initProblemRows();
    initCursor();
    initMagnetic();

    if (window.Livewire) {
        window.dispatchEvent(new Event('vivio:animations-ready'));
    }
});

document.addEventListener('livewire:navigated', () => {
    ScrollTrigger.refresh();
    lenis?.resize();
});

window.addEventListener('beforeunload', () => {
    lenis?.destroy();
    ScrollTrigger.getAll().forEach((trigger) => trigger.kill());
});

export { gsap, ScrollTrigger, lenis };
