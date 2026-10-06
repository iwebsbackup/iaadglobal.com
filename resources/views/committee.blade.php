{{-- resources/views/committee.blade.php
     routes/web.php:  Route::view('/committee', 'committee'); --}}

<x-layouts.app title="Committee | DiCD 2026">

    @php
        $glow = '<div aria-hidden="true" class="pointer-events-none absolute inset-0 -z-10">
        <div class="absolute inset-0 bg-[radial-gradient(rgba(255,255,255,.07)_1px,transparent_1px)] bg-[size:26px_26px] [mask-image:radial-gradient(ellipse_at_center,#000_30%,transparent_75%)]"></div>
        <div class="absolute -top-40 -right-32 size-[520px] rounded-full bg-[radial-gradient(closest-side,rgba(242,198,90,.20),transparent)]"></div>
        <div class="absolute -bottom-48 -left-40 size-[480px] rounded-full bg-[radial-gradient(closest-side,rgba(58,120,200,.30),transparent)]"></div>
    </div>';

        // member = [name (no "Dr."), role lines separated by "|", optional photo filename without .png]
        $pages = [
            'governing' => [
                'label' => 'Governing Council',
                'groups' => [
                    [
                        'title' => 'The Governing Council IAAD',
                        'members' => [
                            ['Anil Ganjoo', 'Principal Founding Director|President', 'dr.anil-kumar-ganjoo'],
                            ['Neeraj Pandey', 'Principal Founding Director|Honorary General Secretary'],
                        ],
                    ],
                    [
                        'title' => '',
                        'members' => [
                            ['Kalpana Sarangi', 'Principal Founding Director', 'dr.kalapana-sarangi'],
                            ['Ajay Sharma', 'Principal Founding Director'],
                            ['Anuj Pall', 'Principal Founding Director'],
                            ['Sachin Dhawan', 'Principal Founding Director'],
                        ],
                    ],
                ],
            ],
            'advisory' => [
                'label' => 'Advisory',
                'groups' => [
                    ['title' => 'Director Operations', 'members' => [['Archana Gulati']]],
                    ['title' => 'Advisory Heads', 'members' => [['Anurag Tiwari'], ['Amit Luthra']]],
                    ['title' => 'Scientific Advisor', 'members' => [['Malavika Kohli']]],
                    ['title' => 'Director of Finance', 'members' => [['Vipul Gupta']]],
                    ['title' => 'Advisor Operations', 'members' => [['Prashant Agarwal']]],
                    [
                        'title' => 'Advisory Board',
                        'members' => [['Madhuri Agarwal'], ['Rajetha Damisetty'], ['Amit Madan'], ['Sumit Gupta']],
                    ],
                ],
            ],
            'international' => [
                'label' => 'International & Regional',
                'groups' => [
                    [
                        'title' => 'International Advisory Board',
                        'members' => [
                            ['S.M. Ahmed Shamim', 'Bangladesh'],
                            ['Sudip Parajuli', 'Nepal'],
                            ['Dharmendra Karn', 'Nepal'],
                            ['Manisha Singh Basukala', 'Nepal'],
                            ['Su Phyo Aung', 'Myanmar'],
                            ['Mohammed Haikal', 'Maldives'],
                        ],
                    ],
                    [
                        'title' => 'Regional Directors',
                        'members' => [
                            ['Shreya Poddar', 'East Kolkata'],
                            ['Ishad Agarwal', 'Kolkata'],
                            ['Abhishek De', 'Kolkata'],
                            ['Indrani Dey', 'Guwahati'],
                            ['Jerryl Banait', 'West Maharashtra'],
                        ],
                    ],
                ],
            ],
            'regional' => [
                'label' => 'Regional Operations',
                'groups' => [
                    ['title' => 'Punjab, Chandigarh, Himachal', 'members' => [['Ameesha Mahajan']]],
                    ['title' => 'Regional Director South', 'members' => [['Karthikraja']]],
                    ['title' => 'Regional Directors North', 'members' => [['Gaurav Mukhija'], ['Amitabh Upadhyay']]],
                    [
                        'title' => 'Regional Directors Central',
                        'members' => [['Rashmi Sharma'], ['Deepak Jakhar'], ['Atula Gupta']],
                    ],
                    ['title' => 'National Head for Regional Operations', 'members' => [['Sukesh MS']]],
                ],
            ],
            'organizing' => [
                'label' => 'Organizing Committee',
                'groups' => [
                    [
                        'title' => 'Patrons',
                        'plain' => true,
                        'members' => [
                            ['Amala Kamat'],
                            ['Ganesh S. Pai'],
                            ['Sanjiv Kandhari'],
                            ['RD Mukhija'],
                            ['RP Gupta'],
                            ['Suresh Talwar'],
                            ['VP Kaushik'],
                            ['Mukesh Girdhar'],
                            ['(Sqn.Ldr) V.K. Upadhyaya'],
                        ],
                    ],
                    [
                        'title' => 'DiCD 2026 Organizing Committee',
                        'members' => [
                            ['Rishi Parashar', 'Organising President'],
                            ['Ajay Sharma', 'Organising Chair'],
                            ['Prashant Agarwal', 'Organising Co-Chair'],
                            ['Gaurav Nakra', 'Organising Secretary'],
                            ['Rahul Arora', 'Organising Co-Secretary'],
                            ['Anuj Pall', 'Scientific Chair'],
                            ['Sachin Dhawan', 'Scientific Co-Chair'],
                            ['Kalpana Sarangi', 'Workshop Chair', 'dr.kalapana-sarangi'],
                            ['Amit Luthra', 'Workshop Co-Chair'],
                            ['Rashmi Sharma', 'Org Secretary Workshop'],
                            ['Deepti Dhingra', 'Org Secretary Workshop'],
                        ],
                    ],
                ],
            ],
            'planning' => [
                'label' => 'Planning & Media',
                'groups' => [
                    [
                        'title' => 'Conference Planning Committee Chairs',
                        'members' => [['Maj. Amitabh Upadhyay', null, 'dr.amitabh-upadhyay'], ['Gaurav Mukhija']],
                    ],
                    ['title' => 'Chief Coordinator Conference', 'members' => [['Mandeep Bhukar'], ['Nitika Nijhara']]],
                    ['title' => 'Advisor Digital Media Campaign DiCD 2026', 'members' => [['Kanika Popli']]],
                ],
            ],
        ];
    @endphp

    {{-- hero --}}
    <section
        class="relative isolate overflow-hidden bg-gradient-to-b from-navy-deep via-navy to-[#041c38] pt-36 pb-20 text-white">
        {!! $glow !!}
        <div class="mx-auto max-w-7xl px-6 text-center">
            <span
                class="inline-flex items-center gap-2 rounded-full border border-gold-light/40 bg-gold-light/15 px-3.5 py-1.5 text-xs font-bold tracking-wider text-gold-light uppercase motion-safe:animate-fade-up">
                <i class="fa-solid fa-users"></i> DiCD 2026 · 19–21 December · Gurugram
            </span>
            <h1
                class="mt-5 font-display text-5xl leading-[1] font-bold tracking-tight sm:text-6xl lg:text-7xl motion-safe:animate-fade-up [animation-delay:80ms]">
                The People Behind <em
                    class="bg-gradient-to-r from-gold-light to-gold bg-clip-text text-transparent not-italic">DiCD</em>
            </h1>
            <p
                class="mx-auto mt-5 max-w-2xl text-lg leading-8 text-white/70 motion-safe:animate-fade-up [animation-delay:140ms]">
                Governing council, advisors, directors and organizing committee.
            </p>
        </div>
    </section>

    <section x-data="{
        tab: 'governing',
        tabs: @js(array_keys($pages)),
        init() { const h = location.hash.slice(1); if (this.tabs.includes(h)) this.tab = h; },
        set(k) {
            this.tab = k;
            history.replaceState(null, '', '#' + k);
        },
    }"
        class="relative isolate overflow-x-clip bg-gradient-to-b from-[#041c38] via-navy-deep to-navy pb-28 text-white">

        <div aria-hidden="true" class="pointer-events-none absolute inset-0 -z-10 overflow-hidden">
            <div
                class="absolute inset-0 bg-[radial-gradient(rgba(255,255,255,.06)_1px,transparent_1px)] bg-[size:26px_26px] [mask-image:radial-gradient(ellipse_at_top,#000_20%,transparent_80%)]">
            </div>
            <div
                class="absolute -top-72 -left-40 size-[480px] rounded-full bg-[radial-gradient(closest-side,rgba(58,120,200,.30),transparent)]">
            </div>
            <div
                class="absolute -right-32 bottom-0 size-[460px] rounded-full bg-[radial-gradient(closest-side,rgba(242,198,90,.14),transparent)]">
            </div>
        </div>

        {{-- tabs (top-20 = header height; adjust if your header differs) --}}
        {{-- <div class="sticky top-20 z-30 border-y border-white/10 bg-navy-deep shadow-lg shadow-black/20 lg:top-34"> --}}
        <div class="sticky top-0 z-30 border-y border-white/10 bg-navy-deep shadow-lg shadow-black/20">
            <div class="mx-auto max-w-7xl overflow-x-auto px-6 py-4">
                <div class="flex gap-3 xl:justify-center" role="tablist">
                    @foreach ($pages as $key => $page)
                        <button type="button" role="tab" @click="set('{{ $key }}')"
                            :aria-selected="tab === '{{ $key }}'"
                            :class="tab === '{{ $key }}'
                                ?
                                'border-gold bg-gradient-to-br from-gold-light to-gold text-navy-deep shadow-lg shadow-gold/30' :
                                'border-white/15 bg-white/10 text-white hover:border-gold-light/60'"
                            class="shrink-0 rounded-full border-[1.5px] px-5 py-2.5 font-display text-sm font-bold whitespace-nowrap transition">
                            {{ $page['label'] }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- panels --}}
        <div class="mx-auto max-w-7xl px-6 pt-14">
            @foreach ($pages as $key => $page)
                <div x-show="tab === '{{ $key }}'" x-cloak x-transition.opacity.duration.300ms role="tabpanel"
                    class="space-y-16">
                    @foreach ($page['groups'] as $group)
                        <div>
                            @if (filled($group['title'] ?? null))
                                <div class="mb-8 flex items-center gap-4">
                                    <span class="h-px flex-1 bg-gradient-to-r from-transparent to-gold-light/40"></span>
                                    <h2
                                        class="rounded-full border border-gold-light/40 bg-gold-light/15 px-5 py-2 text-center font-display text-xs font-bold tracking-wider text-gold-light uppercase sm:text-sm">
                                        {{ $group['title'] }}
                                    </h2>
                                    <span class="h-px flex-1 bg-gradient-to-l from-transparent to-gold-light/40"></span>
                                </div>
                            @endif

                            @if (!empty($group['plain']))
                                <ul class="mx-auto grid max-w-4xl gap-3 sm:grid-cols-2 lg:grid-cols-3">
                                    @foreach ($group['members'] as $m)
                                        <li
                                            class="rounded-2xl border border-white/15 bg-white/10 px-5 py-3.5 text-center font-display font-bold backdrop-blur transition hover:-translate-y-0.5 hover:border-gold-light/50">
                                            Dr. {{ $m[0] }}
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="flex flex-wrap justify-center gap-6">
                                    @foreach ($group['members'] as $m)
                                        <x-member-card :name="$m[0]" :role="$m[1] ?? null" :file="$m[2] ?? null" />
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </section>

</x-layouts.app>
