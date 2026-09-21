import * as THREE from 'three';

/* ========================================
   VIVIO Hero — Three.js Particle Scene
   Premium dark futuristic environment
   ======================================== */

export function initHeroScene(container) {
    if (!container) return null;

    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const isMobile = window.matchMedia('(max-width: 768px)').matches;

    /* — Scene setup — */
    const scene = new THREE.Scene();
    scene.fog = new THREE.FogExp2(0x020914, 0.0008);

    const camera = new THREE.PerspectiveCamera(60, container.clientWidth / container.clientHeight, 0.1, 1000);
    camera.position.set(0, 0, 30);

    const renderer = new THREE.WebGLRenderer({
        antialias: !isMobile,
        alpha: true,
        powerPreference: 'high-performance',
    });
    renderer.setSize(container.clientWidth, container.clientHeight);
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, isMobile ? 1.5 : 2));
    renderer.setClearColor(0x000000, 0);
    container.appendChild(renderer.domElement);

    /* — Mouse tracking — */
    const mouse = { x: 0, y: 0, targetX: 0, targetY: 0 };
    if (!('ontouchstart' in window)) {
        window.addEventListener('mousemove', (e) => {
            mouse.targetX = (e.clientX / window.innerWidth - 0.5) * 2;
            mouse.targetY = (e.clientY / window.innerHeight - 0.5) * 2;
        }, { passive: true });
    }

    /* — Particle field — */
    const particleCount = isMobile ? 120 : 300;
    const particleGeometry = new THREE.BufferGeometry();
    const positions = new Float32Array(particleCount * 3);
    const sizes = new Float32Array(particleCount);
    const alphas = new Float32Array(particleCount);
    const speeds = new Float32Array(particleCount);

    for (let i = 0; i < particleCount; i++) {
        positions[i * 3] = (Math.random() - 0.5) * 80;
        positions[i * 3 + 1] = (Math.random() - 0.5) * 60;
        positions[i * 3 + 2] = (Math.random() - 0.5) * 40 - 10;
        sizes[i] = Math.random() * 2 + 0.5;
        alphas[i] = Math.random() * 0.5 + 0.1;
        speeds[i] = Math.random() * 0.3 + 0.1;
    }

    particleGeometry.setAttribute('position', new THREE.BufferAttribute(positions, 3));
    particleGeometry.setAttribute('aSize', new THREE.BufferAttribute(sizes, 1));
    particleGeometry.setAttribute('aAlpha', new THREE.BufferAttribute(alphas, 1));

    const particleMaterial = new THREE.ShaderMaterial({
        transparent: true,
        depthWrite: false,
        blending: THREE.AdditiveBlending,
        uniforms: {
            uTime: { value: 0 },
            uPixelRatio: { value: Math.min(window.devicePixelRatio, 2) },
        },
        vertexShader: `
            attribute float aSize;
            attribute float aAlpha;
            uniform float uTime;
            uniform float uPixelRatio;
            varying float vAlpha;
            void main() {
                vec3 pos = position;
                pos.y += sin(uTime * 0.3 + position.x * 0.1) * 0.5;
                pos.x += cos(uTime * 0.2 + position.y * 0.08) * 0.3;
                vec4 mvPosition = modelViewMatrix * vec4(pos, 1.0);
                gl_PointSize = aSize * uPixelRatio * (80.0 / -mvPosition.z);
                gl_Position = projectionMatrix * mvPosition;
                vAlpha = aAlpha * (1.0 - smoothstep(20.0, 50.0, -mvPosition.z));
            }
        `,
        fragmentShader: `
            varying float vAlpha;
            void main() {
                float d = length(gl_PointCoord - vec2(0.5));
                if (d > 0.5) discard;
                float alpha = vAlpha * (1.0 - d * 2.0);
                gl_FragColor = vec4(0.18, 0.55, 1.0, alpha * 0.4);
            }
        `,
    });

    const particles = new THREE.Points(particleGeometry, particleMaterial);
    scene.add(particles);

    /* — Orbital rings — */
    const ringGroup = new THREE.Group();
    scene.add(ringGroup);

    const ringMaterial = new THREE.LineBasicMaterial({
        color: 0x1677ff,
        transparent: true,
        opacity: 0.12,
    });

    for (let i = 0; i < 3; i++) {
        const radius = 12 + i * 6;
        const segments = 64;
        const ringGeometry = new THREE.BufferGeometry();
        const ringPositions = new Float32Array(segments * 3);
        for (let j = 0; j < segments; j++) {
            const angle = (j / segments) * Math.PI * 2;
            ringPositions[j * 3] = Math.cos(angle) * radius;
            ringPositions[j * 3 + 1] = Math.sin(angle) * radius * 0.3;
            ringPositions[j * 3 + 2] = 0;
        }
        ringGeometry.setAttribute('position', new THREE.BufferAttribute(ringPositions, 3));
        const ring = new THREE.Line(ringGeometry, ringMaterial.clone());
        ring.rotation.x = 0.3 + i * 0.15;
        ring.rotation.z = i * 0.2;
        ringGroup.add(ring);
    }

    /* — Floating geometric nodes — */
    const nodeGroup = new THREE.Group();
    scene.add(nodeGroup);

    const nodeMaterial = new THREE.MeshBasicMaterial({
        color: 0x2f8cff,
        transparent: true,
        opacity: 0.15,
        wireframe: true,
    });

    const nodeCount = isMobile ? 4 : 8;
    const nodes = [];
    for (let i = 0; i < nodeCount; i++) {
        const geo = i % 2 === 0
            ? new THREE.OctahedronGeometry(0.8 + Math.random() * 0.6, 0)
            : new THREE.TetrahedronGeometry(0.6 + Math.random() * 0.4, 0);
        const mesh = new THREE.Mesh(geo, nodeMaterial.clone());
        mesh.position.set(
            (Math.random() - 0.5) * 40,
            (Math.random() - 0.5) * 30,
            (Math.random() - 0.5) * 20 - 15
        );
        mesh.rotation.set(
            Math.random() * Math.PI,
            Math.random() * Math.PI,
            Math.random() * Math.PI
        );
        nodeGroup.add(mesh);
        nodes.push({
            mesh,
            rotSpeed: (Math.random() - 0.5) * 0.01,
            floatSpeed: Math.random() * 0.3 + 0.1,
            floatOffset: Math.random() * Math.PI * 2,
        });
    }

    /* — Central glow — */
    const glowGeometry = new THREE.PlaneGeometry(30, 30);
    const glowMaterial = new THREE.ShaderMaterial({
        transparent: true,
        depthWrite: false,
        uniforms: {
            uTime: { value: 0 },
        },
        vertexShader: `
            varying vec2 vUv;
            void main() {
                vUv = uv;
                gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.0);
            }
        `,
        fragmentShader: `
            uniform float uTime;
            varying vec2 vUv;
            void main() {
                float d = distance(vUv, vec2(0.5));
                float glow = exp(-d * 3.0) * 0.15;
                float pulse = sin(uTime * 0.5) * 0.03 + 0.97;
                glow *= pulse;
                vec3 color = mix(vec3(0.09, 0.47, 1.0), vec3(0.4, 0.89, 1.0), d);
                gl_FragColor = vec4(color, glow);
            }
        `,
    });
    const glowMesh = new THREE.Mesh(glowGeometry, glowMaterial);
    glowMesh.position.z = -20;
    scene.add(glowMesh);

    /* — Animation loop — */
    let time = 0;
    let animationId;
    let isVisible = true;

    const clock = new THREE.Clock();

    function animate() {
        if (!isVisible) return;
        animationId = requestAnimationFrame(animate);

        const delta = clock.getDelta();
        time += delta;

        /* Mouse smoothing */
        mouse.x += (mouse.targetX - mouse.x) * 0.05;
        mouse.y += (mouse.targetY - mouse.y) * 0.05;

        if (!reducedMotion) {
            /* Rotate ring group */
            ringGroup.rotation.y += 0.001;
            ringGroup.rotation.x = Math.sin(time * 0.1) * 0.1;

            /* Rotate particles subtly */
            particles.rotation.y += 0.0003;
            particles.rotation.x = mouse.y * 0.05;

            /* Animate nodes */
            nodes.forEach((n) => {
                n.mesh.rotation.x += n.rotSpeed;
                n.mesh.rotation.y += n.rotSpeed * 0.7;
                n.mesh.position.y += Math.sin(time * n.floatSpeed + n.floatOffset) * 0.003;
            });

            /* Camera parallax */
            camera.position.x += (mouse.x * 2 - camera.position.x) * 0.02;
            camera.position.y += (-mouse.y * 1.5 - camera.position.y) * 0.02;
            camera.lookAt(0, 0, 0);
        }

        /* Update shader uniforms */
        particleMaterial.uniforms.uTime.value = time;
        glowMaterial.uniforms.uTime.value = time;

        renderer.render(scene, camera);
    }

    animate();

    /* — Resize handler — */
    function onResize() {
        const w = container.clientWidth;
        const h = container.clientHeight;
        camera.aspect = w / h;
        camera.updateProjectionMatrix();
        renderer.setSize(w, h);
        renderer.setPixelRatio(Math.min(window.devicePixelRatio, isMobile ? 1.5 : 2));
    }

    window.addEventListener('resize', onResize, { passive: true });

    /* — Visibility observer — */
    const observer = new IntersectionObserver(
        ([entry]) => {
            isVisible = entry.isIntersecting;
            if (isVisible && !animationId) animate();
        },
        { threshold: 0.01 }
    );
    observer.observe(container);

    /* — Cleanup — */
    return {
        destroy() {
            observer.disconnect();
            window.removeEventListener('resize', onResize);
            cancelAnimationFrame(animationId);
            renderer.dispose();
            particleGeometry.dispose();
            particleMaterial.dispose();
            ringMaterial.dispose();
            nodeMaterial.dispose();
            glowGeometry.dispose();
            glowMaterial.dispose();
            container.removeChild(renderer.domElement);
        },
    };
}
