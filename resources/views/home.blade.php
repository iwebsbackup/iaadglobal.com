<x-layouts.app title="DICD 2026 | Dialogues in Interventional & Clinical Dermatology">

    <!-- Hero -->
    <section id="home"
        class="relative isolate flex min-h-svh items-center overflow-hidden bg-gradient-to-b from-navy-deep via-navy to-[#041c38] pt-32 pb-20 text-white lg:pt-36">

        {{-- background: dot grid + glows --}}
        <div aria-hidden="true" class="pointer-events-none absolute inset-0 -z-10">
            <div
                class="absolute inset-0 bg-[radial-gradient(rgba(255,255,255,.08)_1px,transparent_1px)] bg-[size:26px_26px] [mask-image:radial-gradient(ellipse_at_center,#000_30%,transparent_75%)]">
            </div>
            <div
                class="absolute -top-40 -right-32 size-[520px] rounded-full bg-[radial-gradient(closest-side,rgba(242,198,90,.20),transparent)]">
            </div>
            <div
                class="absolute -bottom-48 -left-40 size-[480px] rounded-full bg-[radial-gradient(closest-side,rgba(58,120,200,.30),transparent)]">
            </div>
        </div>

        <div class="mx-auto grid max-w-7xl items-center gap-14 px-6 lg:grid-cols-[1.1fr_.9fr]">

            {{-- left: text --}}
            <div>
                <div class="flex flex-wrap items-center gap-3 motion-safe:animate-fade-up">
                    <span
                        class="inline-flex items-center gap-2 rounded-full border border-gold-light/40 bg-gold-light/15 px-3.5 py-1.5 text-xs font-bold tracking-wider text-gold-light uppercase">
                        <i class="fa-solid fa-award"></i> 10th Anniversary Edition
                    </span>
                    <span class="text-xs font-bold tracking-widest text-white/60 uppercase">You're invited</span>
                </div>

                <h1
                    class="mt-5 font-display text-6xl leading-[.95] font-bold tracking-tight sm:text-7xl lg:text-8xl motion-safe:animate-fade-up [animation-delay:80ms]">
                    DiCD<em
                        class="ml-3 bg-gradient-to-r from-gold-light to-gold bg-clip-text text-transparent not-italic">2026</em>
                </h1>

                <p
                    class="mt-4 max-w-lg text-base tracking-wide text-white/65 motion-safe:animate-fade-up [animation-delay:140ms]">
                    Dialogues in Interventional &amp; Clinical Dermatology
                </p>

                <div
                    class="mt-6 inline-flex flex-wrap items-baseline gap-x-2.5 gap-y-1 rounded-2xl border border-gold-light/30 bg-white/5 px-4 py-2.5 text-sm font-bold backdrop-blur motion-safe:animate-fade-up [animation-delay:200ms]">
                    <span class="text-[.66rem] tracking-widest text-gold-light uppercase">Theme</span>
                    <span>The Clinical Edge —</span>
                    <em class="font-semibold text-white/85">"Where Diagnosis Meets Practice"</em>
                </div>

                <p
                    class="mt-6 max-w-xl text-lg leading-relaxed text-white/80 motion-safe:animate-fade-up [animation-delay:260ms]">
                    Three immersive days of evidence-led learning, procedural innovation and global collaboration in the
                    heart of Delhi NCR.
                </p>

                {{-- date + venue --}}
                <div
                    class="mt-7 grid max-w-xl gap-3 sm:grid-cols-2 motion-safe:animate-fade-up [animation-delay:320ms]">
                    <div
                        class="flex items-center gap-3.5 rounded-2xl border border-white/15 bg-white/10 px-4 py-3.5 backdrop-blur">
                        <span
                            class="grid size-11 shrink-0 place-items-center rounded-xl bg-gold-light/15 text-gold-light">
                            <i class="fa-solid fa-calendar-days"></i>
                        </span>
                        <div>
                            <span class="block text-[.68rem] tracking-wider text-white/55 uppercase">Date</span>
                            <strong class="text-sm">19–21 December 2026</strong>
                        </div>
                    </div>
                    <div
                        class="flex items-center gap-3.5 rounded-2xl border border-white/15 bg-white/10 px-4 py-3.5 backdrop-blur">
                        <span
                            class="grid size-11 shrink-0 place-items-center rounded-xl bg-gold-light/15 text-gold-light">
                            <i class="fa-solid fa-location-dot"></i>
                        </span>
                        <div>
                            <span class="block text-[.68rem] tracking-wider text-white/55 uppercase">Venue</span>
                            <strong class="text-sm">The Leela Ambience, Gurugram</strong>
                        </div>
                    </div>
                </div>

                {{-- CTAs --}}
                <div class="mt-8 flex flex-wrap gap-3 motion-safe:animate-fade-up [animation-delay:380ms]">
                    <a href="/registration" class="btn-fill">
                        Register for DICD <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                    <a href="{{ asset('brochure.pdf') }}" download="DICD-2026-Brochure.pdf" class="btn-line">
                        <i class="fa-solid fa-download"></i> Download Brochure
                    </a>
                </div>

                {{-- countdown --}}
                <div x-data="{
                    d: '00',
                    h: '00',
                    m: '00',
                    s: '00',
                    live: false,
                    target: new Date('2026-12-19T09:00:00+05:30').getTime(),
                    timer: null,
                    tick() {
                        const diff = this.target - Date.now();
                        if (diff <= 0) {
                            this.live = true;
                            clearInterval(this.timer);
                            return;
                        }
                        const pad = (v) => String(v).padStart(2, '0');
                        this.d = pad(Math.floor(diff / 86400000));
                        this.h = pad(Math.floor((diff % 86400000) / 3600000));
                        this.m = pad(Math.floor((diff % 3600000) / 60000));
                        this.s = pad(Math.floor((diff % 60000) / 1000));
                    },
                }" x-init="tick();
                timer = setInterval(() => tick(), 1000)" role="timer" aria-label="Countdown to conference"
                    class="mt-10 max-w-md motion-safe:animate-fade-up [animation-delay:440ms]">

                    <div x-show="!live" class="grid grid-cols-4 gap-3">
                        @foreach ([['d', 'Days'], ['h', 'Hours'], ['m', 'Mins'], ['s', 'Secs']] as [$key, $label])
                            <div class="rounded-2xl border border-white/15 bg-white/5 py-3 text-center backdrop-blur">
                                <strong
                                    class="block font-display text-2xl font-bold text-gold-light tabular-nums sm:text-3xl"
                                    x-text="{{ $key }}">00</strong>
                                <span
                                    class="text-[.62rem] tracking-widest text-white/55 uppercase">{{ $label }}</span>
                            </div>
                        @endforeach
                    </div>

                    <p x-show="live" x-cloak class="font-display text-lg font-bold text-gold-light">
                        DICD 2026 is live now.
                    </p>
                </div>
            </div>

            {{-- right: image --}}
            <div class="relative mx-auto w-full max-w-md motion-safe:animate-fade-up [animation-delay:200ms]">

                {{-- offset outline arch --}}
                <div aria-hidden="true"
                    class="absolute inset-0 translate-x-4 translate-y-4 rounded-t-[220px] rounded-b-2xl border-2 border-gold-light/50">
                </div>

                {{-- 10 years badge --}}
                <div
                    class="absolute -top-4 -right-2 z-10 max-w-44 rounded-2xl bg-white p-4 shadow-soft sm:-right-4 sm:p-5">
                    <strong class="block font-display text-3xl leading-none text-navy">10</strong>
                    <span class="mt-1.5 block text-xs leading-snug font-bold text-muted">Years of academic impact in
                        dermatology</span>
                </div>

                <div
                    class="relative aspect-3/4 overflow-hidden rounded-t-[220px] rounded-b-2xl border-[6px] border-white shadow-card">
                    <img src="{{ asset('images/venue.jpg') }}" alt="The Leela Ambience, Gurugram" fetchpriority="high"
                        class="size-full object-cover object-[center_38%]">
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-[#041c38]/70 via-transparent to-transparent to-55%">
                    </div>
                    <div class="absolute inset-x-5 bottom-5">
                        <span class="block text-[.68rem] tracking-widest text-gold-light uppercase">The Leela
                            Ambience</span>
                        <strong class="font-display text-lg">Gurugram</strong>
                    </div>
                </div>
            </div>

        </div>
    </section>

    @php
        $glow = '<div aria-hidden="true" class="pointer-events-none absolute inset-0 -z-10">
        <div class="absolute inset-0 bg-[radial-gradient(rgba(255,255,255,.07)_1px,transparent_1px)] bg-[size:26px_26px] [mask-image:radial-gradient(ellipse_at_center,#000_30%,transparent_75%)]"></div>
        <div class="absolute -top-40 -right-32 size-[460px] rounded-full bg-[radial-gradient(closest-side,rgba(242,198,90,.16),transparent)]"></div>
        <div class="absolute -bottom-40 -left-32 size-[420px] rounded-full bg-[radial-gradient(closest-side,rgba(58,120,200,.26),transparent)]"></div>
    </div>';
        $areas = [
            ['fa-magnifying-glass', 'Inflammatory Skin Diseases'],
            ['fa-bacterium', 'Infectious Dermatologic Disorders'],
            ['fa-water', 'Pigmentary & Hair Disorders'],
            ['fa-microscope', 'Dermatopathology & Diagnostics'],
            ['fa-hand-holding-medical', 'Allergy & Immunodermatology'],
            ['fa-capsules', 'Therapeutic Updates & Clinical Trials'],
        ];
        $tabs = [
            'sessions' => [
                'label' => 'Scientific Sessions',
                'items' => [
                    'Atopic Dermatitis: The Itch and the Scratch',
                    'Psoriasis: Skin to Systemic',
                    '50 Shades of Acne',
                    'Pigmentation',
                    'Immunology',
                    'Difficult-to-Treat Dermatoses',
                    'Trichology',
                    'New Biologics',
                    'Regenerative Therapies',
                    'Aesthetics Beyond Face',
                    'Practice Management',
                    'Networking opportunities with international faculty',
                    'Young Turks session for dermatologists <5 years of practice',
                    'Global cadaveric sessions and simulation-based learning',
                ],
            ],
            'workshops' => [
                'label' => 'Workshops',
                'items' => [
                    'AI in Dermatology: A Unique Concept',
                    'Botulinum Toxin A – Upper Face',
                    'Botulinum Toxin A – Lower Face',
                    'Contour Threads',
                    'Fillers (Mid Face)',
                    'Fillers (Lower Face)',
                    'Hydrobooster',
                    'Mastering Injectables with Simulation Models (Digital Cadaver Table + Face Simulation Models)',
                ],
            ],
            'regenerative' => [
                'label' => 'Regenerative Therapies',
                'items' => ['Exosomes', 'Boosters (Profhilo, Skinvive, Vital)', 'PDRN', 'PN'],
            ],
        ];
        $stats = [
            [1500, '+', 'Delegates Expected'],
            [85, '+', 'Expert Faculty'],
            [45, '+', 'Scientific Sessions'],
            [18, '', 'Countries Represented'],
        ];
    @endphp

    {{-- Scientific focus --}}
    <section
        class="relative isolate overflow-hidden bg-gradient-to-b from-[#041c38] via-navy-deep to-navy py-16 text-white sm:py-20 lg:py-24">
        <div aria-hidden="true" class="pointer-events-none absolute inset-0 -z-10 overflow-hidden">
            <div
                class="absolute inset-0 bg-[radial-gradient(rgba(255,255,255,.07)_1px,transparent_1px)] bg-[size:26px_26px] [mask-image:radial-gradient(ellipse_at_center,#000_30%,transparent_75%)]">
            </div>
            <div
                class="absolute -top-40 -left-32 size-[320px] rounded-full bg-[radial-gradient(closest-side,rgba(58,120,200,.25),transparent)] sm:size-[420px] lg:size-[480px]">
            </div>
            <div
                class="absolute -right-24 -bottom-32 size-[300px] rounded-full bg-[radial-gradient(closest-side,rgba(242,198,90,.12),transparent)] sm:size-[380px] lg:size-[420px]">
            </div>
        </div>

        <div class="mx-auto max-w-7xl px-6">
            <div class="mx-auto mb-10 max-w-3xl text-center sm:mb-12 lg:mb-14">
                <span
                    class="inline-flex rounded-full border border-gold-light/40 bg-gold-light/15 px-3.5 py-1.5 text-xs font-bold tracking-wider text-gold-light uppercase">
                    Scientific Focus Areas
                </span>
                <h2 class="mt-5 font-display text-3xl leading-tight font-bold tracking-tight sm:text-4xl lg:text-5xl">
                    Six pillars of the
                    <em class="bg-gradient-to-r from-gold-light to-gold bg-clip-text text-transparent not-italic">clinical
                        edge</em>
                </h2>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($areas as [$icon, $label])
                    <div
                        class="group flex items-center gap-4 rounded-2xl border border-white/15 bg-white/10 p-5 backdrop-blur transition duration-300 hover:-translate-y-1 hover:border-gold-light/50 hover:bg-white/[0.13]">
                        <span
                            class="grid size-12 shrink-0 place-items-center rounded-xl bg-gold-light/15 text-lg text-gold-light transition duration-300 group-hover:bg-gold-light/25 sm:size-14 sm:text-xl">
                            <i class="fa-solid {{ $icon }}"></i>
                        </span>
                        <p class="font-display text-base leading-snug font-bold sm:text-lg">{{ $label }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Sister society --}}
    <section id="sister-society" class="bg-pale-blue py-16 sm:py-20">
        <div class="mx-auto max-w-5xl px-6">
            <div class="mx-auto mb-10 max-w-2xl text-center">
                <div class="mb-4 text-xs font-bold tracking-widest text-gold uppercase">In association with</div>
                <h2
                    class="font-display text-3xl leading-tight font-bold tracking-tight text-navy-deep sm:text-4xl lg:text-5xl">
                    Sister Society for DiCD — IAAD</h2>
            </div>

            <div class="grid grid-cols-2 gap-4 sm:gap-6 lg:grid-cols-4">
                @for ($i = 1; $i <= 4; $i++)
                    <div
                        class="flex h-24 items-center justify-center rounded-2xl border border-navy/10 bg-white p-4 shadow-soft transition hover:-translate-y-1 sm:h-28 lg:h-32">
                        <img src="{{ asset('images/associative-companies/associative-' . $i . '.jpg') }}"
                            alt="Sister society logo {{ $i }}" class="max-h-full max-w-full object-contain">
                    </div>
                @endfor
            </div>
        </div>
    </section>

    {{-- Welcome letter --}}
    <section class="relative isolate overflow-hidden bg-gradient-to-b from-navy to-navy-deep py-24 text-white">
        {!! $glow !!}
        <div class="mx-auto max-w-4xl px-6">
            <div
                class="relative overflow-hidden rounded-[28px] border border-white/15 bg-white/10 p-8 backdrop-blur sm:p-12">
                <div class="absolute inset-y-0 left-0 w-2 bg-gradient-to-b from-gold-light to-gold"></div>
                <div class="mb-4 flex items-center gap-2.5 text-xs font-bold tracking-widest text-gold-light uppercase">
                    <span class="h-px w-7 bg-gold-light"></span> Welcome Letter
                </div>
                <h2 class="mb-8 font-display text-3xl leading-tight font-bold tracking-tight sm:text-4xl lg:text-5xl">A
                    Warm Welcome to DICD 2026</h2>
                <div class="space-y-5 leading-8 text-white/80">
                    <p class="font-display text-xl text-white">Dear Colleagues and Friends,</p>
                    <p>It is our immense pleasure to welcome you to the 10th Anniversary Edition of DICD – Dialogues in
                        Interventional &amp; Clinical Dermatology, to be held at The Leela Ambience, Gurugram, from 19th
                        to 21st December 2026.</p>
                    <p>Over the past decade, DICD has grown into one of the most respected academic platforms in
                        clinical and aesthetic dermatology, fostering innovation, scientific excellence, and meaningful
                        collaboration. What began as a vision to create a unique forum for knowledge sharing has evolved
                        into a premier meeting where experts and delegates come together to exchange ideas, challenge
                        conventional thinking, and shape the future of dermatology.</p>
                    <p>This landmark edition has been thoughtfully curated to bring together distinguished national and
                        international faculty who will present the latest advances in clinical dermatology, aesthetic
                        procedures, injectables, lasers, energy-based devices, dermatologic surgery, regenerative
                        aesthetics, trichology, and emerging technologies transforming patient care.</p>
                    <p>Our scientific programme promises insightful lectures, interactive panel discussions, live
                        demonstrations, evidence-based clinical updates, and practical take-home learning, offering
                        every delegate an enriching and inspiring academic experience.</p>
                    <p>Set amidst the vibrant energy of Delhi NCR, Gurugram provides the perfect backdrop to celebrate a
                        decade of excellence, innovation, and friendship.</p>
                    <p>And today, as we celebrate our 10th milestone edition, we say this with all humility, this
                        journey would not have been possible without YOU. Your trust, unwavering support, enthusiastic
                        participation, and commitment to lifelong learning have been the foundation of DICD's success
                        over the last ten years.</p>
                    <p>As we honour this remarkable milestone, we also look ahead with renewed passion and purpose,
                        committed to advancing dermatology through education, collaboration, and innovation.</p>
                    <blockquote
                        class="my-6 rounded-r-2xl border-l-[3px] border-gold-light bg-white/10 px-6 py-5 font-display text-lg font-bold text-gold-light italic">
                        "A decade of excellence, innovation, and friendship — DICD 2026 marks not just ten remarkable
                        years, but a shared journey of learning, collaboration, and shaping the future of dermatology"
                    </blockquote>
                    <p>We warmly invite you to join us at The Leela Ambience, Gurugram, from 19th to 21st December 2026,
                        for three unforgettable days of learning, networking, celebration, and inspiration.</p>
                </div>
                <div class="mt-8 border-t border-white/15 pt-6">
                    <span class="block text-white/70">Warm regards,</span>
                    <span class="block text-sm tracking-wide text-white/55">Team DICD · Scientific &amp; Organising
                        Committee</span>
                    <div class="mt-5 flex flex-wrap gap-8">
                        @foreach ([['dr.anil-kumar-ganjoo', 'Dr. Anil Kumar Ganjoo', 'President'], ['dr.neeraj-pandey', 'Dr. Neeraj Pandey', 'Hon. General Secretary']] as [$f, $n, $r])
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('images/faculty/' . $f . '.png') }}" alt="{{ $n }}"
                                    class="size-16 rounded-xl border-2 border-gold-light object-cover">
                                <div><strong class="block font-display text-lg">{{ $n }}</strong><span
                                        class="mt-0.5 block text-[.7rem] font-bold tracking-wider text-gold-light uppercase">{{ $r }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Scientific highlights --}}
    <section id="highlights" class="bg-light-blue py-24">
        <div class="mx-auto max-w-4xl px-6">
            <div class="mx-auto mb-12 max-w-2xl text-center">
                <div class="mb-4 text-xs font-bold tracking-widest text-gold uppercase">What to expect</div>
                <h2
                    class="mb-4 font-display text-3xl leading-tight font-bold tracking-tight text-navy-deep sm:text-4xl lg:text-5xl">
                    Scientific Highlights</h2>
                <p class="text-lg leading-8 text-muted">A closer look at the sessions, workshops and regenerative
                    therapy tracks across the three days.</p>
            </div>
            <div x-data="{ tab: 'sessions' }">
                <div class="mb-9 flex flex-wrap justify-center gap-3" role="tablist">
                    @foreach ($tabs as $key => $tab)
                        <button type="button" role="tab" @click="tab = '{{ $key }}'"
                            :aria-selected="tab === '{{ $key }}'"
                            :class="tab === '{{ $key }}' ?
                                'border-gold bg-gradient-to-br from-gold-light to-gold text-navy-deep shadow-lg shadow-gold/30' :
                                'border-navy/10 bg-white text-navy-deep hover:border-gold'"
                            class="rounded-full border-[1.5px] px-5 py-3 font-display text-sm font-bold transition sm:px-6">{{ $tab['label'] }}</button>
                    @endforeach
                </div>
                @foreach ($tabs as $key => $tab)
                    <div x-show="tab === '{{ $key }}'" x-cloak x-transition.opacity.duration.300ms
                        role="tabpanel">
                        <ul class="grid gap-3 md:grid-cols-2">
                            @foreach ($tab['items'] as $item)
                                <li
                                    class="flex items-start gap-3 rounded-2xl border border-navy/10 bg-white p-4 text-[.95rem] leading-relaxed font-semibold text-dark-navy shadow-soft">
                                    <span
                                        class="grid size-7 shrink-0 place-items-center rounded-lg bg-navy text-[.65rem] text-gold-light"><i
                                            class="fa-solid fa-angles-right"></i></span>{{ $item }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Stats --}}
    <section class="relative isolate overflow-hidden bg-navy-deep py-16 text-white">
        {!! $glow !!}
        <div class="mx-auto grid max-w-7xl grid-cols-2 gap-4 px-6 lg:grid-cols-4">
            @foreach ($stats as [$target, $suffix, $label])
                <div x-data="{ n: 0 }"
                    x-intersect.once="const s = performance.now(); const f = (t) => { const p = Math.min((t - s) / 1500, 1); n = Math.floor({{ $target }} * (1 - Math.pow(1 - p, 3))); if (p < 1) requestAnimationFrame(f); }; requestAnimationFrame(f);"
                    class="rounded-2xl border border-white/15 bg-white/10 px-4 py-6 text-center backdrop-blur">
                    <strong class="block font-display text-4xl font-bold text-gold-light tabular-nums sm:text-5xl"
                        x-text="n.toLocaleString() + '{{ $suffix }}'">0{{ $suffix }}</strong>
                    <span
                        class="mt-1 block text-xs font-bold tracking-widest text-white/60 uppercase">{{ $label }}</span>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Sponsors --}}
    <section class="group overflow-hidden bg-pale-blue py-20">
        <div class="mx-auto mb-10 max-w-2xl px-6 text-center">
            <div class="mb-4 text-xs font-bold tracking-widest text-gold uppercase">Educational Grant</div>
            <h2
                class="font-display text-3xl leading-tight font-bold tracking-tight text-navy-deep sm:text-4xl lg:text-5xl">
                With Support from Leading Organisations</h2>
        </div>
        <div class="overflow-hidden [mask-image:linear-gradient(90deg,transparent,#000_6%,#000_94%,transparent)]">
            <div class="flex w-max animate-marquee items-center gap-6 group-hover:[animation-play-state:paused]">
                @foreach ([1, 2] as $pass)
                    @for ($i = 1; $i <= 15; $i++)
                        <div @if ($pass === 2) aria-hidden="true" @endif
                            class="flex h-20 w-32 shrink-0 items-center justify-center rounded-2xl border border-navy/10 bg-white px-4 py-3 shadow-soft sm:h-24 sm:w-44">
                            <img src="{{ asset(sprintf('images/sponser/sponser-%02d.png', $i)) }}"
                                alt="Sponsor logo {{ $i }}"
                                class="max-h-full max-w-full object-contain transition hover:scale-105">
                        </div>
                    @endfor
                @endforeach
            </div>
        </div>
    </section>

    {{-- Venue teaser --}}
    <section class="relative isolate overflow-hidden bg-gradient-to-b from-navy to-[#041c38] py-24 text-white">
        {!! $glow !!}
        <div class="mx-auto grid max-w-7xl items-center gap-12 px-6 lg:grid-cols-2">
            <div
                class="relative aspect-4/3 overflow-hidden rounded-t-[160px] rounded-b-2xl border-[6px] border-white shadow-card">
                <img src="{{ asset('images/venue.jpg') }}" alt="The Leela Ambience, Gurugram"
                    class="size-full object-cover">
            </div>
            <div>
                <div class="mb-4 text-xs font-bold tracking-widest text-gold-light uppercase">Venue</div>
                <h2 class="font-display text-3xl leading-tight font-bold tracking-tight sm:text-4xl lg:text-5xl">The
                    Leela Ambience, Gurugram</h2>
                <p class="mt-4 max-w-lg text-lg leading-8 text-white/75">Eight km from Delhi's airport, beside a
                    1,000-acre forest. See the venue, how to reach it, and what to explore in Delhi.</p>
                <a href="/venue" class="btn-fill mt-8">Venue &amp; Delhi guide <i
                        class="fa-solid fa-arrow-right text-xs"></i></a>
            </div>
        </div>
    </section>
</x-layouts.app>
