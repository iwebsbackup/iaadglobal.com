<x-layouts.app title="Venue & Delhi | DICD 2026">
    @php
    $glow = '<div aria-hidden="true" class="pointer-events-none absolute inset-0 -z-10">
        <div class="absolute inset-0 bg-[radial-gradient(rgba(255,255,255,.07)_1px,transparent_1px)] bg-[size:26px_26px] [mask-image:radial-gradient(ellipse_at_center,#000_30%,transparent_75%)]"></div>
        <div class="absolute -top-40 -right-32 size-[460px] rounded-full bg-[radial-gradient(closest-side,rgba(242,198,90,.16),transparent)]"></div>
        <div class="absolute -bottom-40 -left-32 size-[420px] rounded-full bg-[radial-gradient(closest-side,rgba(58,120,200,.26),transparent)]"></div>
    </div>';
    $facts = [
    ['fa-bed', '412', 'Rooms, suites & residences'],
    ['fa-people-roof', '12', 'Meeting & event rooms'],
    ['fa-plane-departure', '8 km', 'From Delhi airport (IGI)'],
    ['fa-tree', '1,000 acre', 'Adjoining forest'],
    ];
    $distances = [
    ['Indira Gandhi International Airport', '8 km'],
    ['Yashobhoomi Convention Centre', '11 km'],
    ['Qutub Minar', '≈15 km'],
    ['Central Delhi', '23 km'],
    ];
    $amenities = [
    ['fa-spa', 'The Leela Spa', '11 therapy rooms, sauna, steam and relaxation lounge overlooking Rajokri greenery.'],
    ['fa-golf-ball-tee', 'Golf Greens', 'A 9-hole golf experience on the property.'],
    ['fa-palette', 'The Leela Art Gallery', 'An immersive art walk through the hotel.'],
    ['fa-utensils', 'Dining', 'Multiple restaurants, a bar and a patisserie.'],
    ['fa-bag-shopping', 'Ambience Mall', '230+ stores and food outlets in the same lifestyle complex.'],
    ['fa-dumbbell', 'Fitness & Club Lounge', 'Fitness centre and club lounge for in-house guests.'],
    ];
    $monuments = [
    ['fa-chess-rook', 'The Red Fort', 'Delhi', 'The Red Fort Complex was built as the palace fort of Shahjahanabad, the new capital of the fifth Mughal Emperor of India, Shah Jahan. Named for its massive enclosing walls of red sandstone, it is adjacent to an older fort, the Salimgarh, built by Islam Shah Suri in 1546, with which it forms the Red Fort Complex.'],
    ['fa-monument', 'India Gate', 'New Delhi', 'At the centre of New Delhi stands the 42 m high India Gate, an "Arc-de-Triomphe"-like archway in the middle of a crossroad. Almost similar to its French counterpart, it commemorates the 70,000 Indian soldiers who lost their lives fighting for the British Army during World War I. The memorial bears the names of more than 13,516 British and Indian soldiers killed in the Northwestern Frontier in the Afghan war of 1919.'],
    ['fa-tower-observation', 'Qutub Minar', 'Delhi', 'Built in the 13th century, Qutub Minar is not only the highest brick minaret in the world but also one of the famous historical landmarks of India. A UNESCO World Heritage Site, it attracts thousands of visitors every day. Visitors also come across the surrounding archaeological area, comprising funerary buildings, notably the magnificent Alai-Darwaza Gate, a masterpiece of Indo-Muslim art built in 1311, and two mosques.'],
    ['fa-synagogue', 'Taj Mahal', 'Agra, Uttar Pradesh', 'The Taj Mahal is located on the right bank of the Yamuna River in a vast Mughal garden of nearly 17 hectares, in the Agra District of Uttar Pradesh. It was built by Mughal Emperor Shah Jahan in memory of his wife Mumtaz Mahal, with construction starting in 1632 AD and completed in 1648 AD. The mosque, guest house and main gateway on the south, the outer courtyard and its cloisters were added subsequently and completed in 1653 AD. Several historical and Quranic inscriptions in Arabic script have helped set the chronology of the Taj Mahal.'],
    ];
    @endphp

    {{-- Header --}}
    <section class="relative isolate overflow-hidden bg-gradient-to-b from-navy-deep via-navy to-[#041c38] pt-36 pb-24 text-white">
        {!! $glow !!}
        <div class="mx-auto grid max-w-7xl items-center gap-12 px-6 lg:grid-cols-[1.1fr_.9fr]">
            <div class="motion-safe:animate-fade-up">
                <span class="inline-flex items-center gap-2 rounded-full border border-gold-light/40 bg-gold-light/15 px-3.5 py-1.5 text-xs font-bold tracking-wider text-gold-light uppercase"><i class="fa-solid fa-location-dot"></i> Conference Venue</span>
                <h1 class="mt-5 font-display text-5xl leading-[1] font-bold tracking-tight sm:text-6xl lg:text-7xl">The Leela <em class="bg-gradient-to-r from-gold-light to-gold bg-clip-text text-transparent not-italic">Ambience</em>, Gurugram</h1>
                <p class="mt-6 max-w-xl text-lg leading-relaxed text-white/80">A five-star hotel on Ambience Island, NH 8, at the confluence of Delhi and Gurugram, adjoining a 1,000-acre forest and part of a lifestyle complex with Ambience Mall.</p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="https://www.google.com/maps/search/?api=1&query=The%20Leela%20Ambience%2C%20Gurugram" target="_blank" rel="noopener" class="btn-fill">Open in Google Maps</a>
                    <a href="#delhi" class="btn-line">Explore Delhi</a>
                </div>
            </div>
            <div class="relative mx-auto w-full max-w-md motion-safe:animate-fade-up [animation-delay:150ms]">
                <div aria-hidden="true" class="absolute inset-0 translate-x-4 translate-y-4 rounded-t-[220px] rounded-b-2xl border-2 border-gold-light/50"></div>
                <div class="relative aspect-3/4 overflow-hidden rounded-t-[220px] rounded-b-2xl border-[6px] border-white shadow-card">
                    <img src="{{ asset('images/venue.jpg') }}" alt="The Leela Ambience, Gurugram" class="size-full object-cover object-[center_38%]" fetchpriority="high">
                </div>
            </div>
        </div>
    </section>

    {{-- Facts --}}
    <section class="relative z-10 -mt-10">
        <div class="mx-auto grid max-w-7xl grid-cols-2 gap-4 px-6 lg:grid-cols-4">
            @foreach ($facts as [$icon, $value, $label])
            <div class="rounded-2xl border border-navy/10 bg-white p-6 text-center shadow-card">
                <i class="fa-solid {{ $icon }} text-xl text-gold"></i>
                <strong class="mt-2 block font-display text-3xl text-navy">{{ $value }}</strong>
                <span class="text-sm font-semibold text-muted">{{ $label }}</span>
            </div>
            @endforeach
        </div>
    </section>

    {{-- Getting there + amenities --}}
    <section class="bg-pale-blue py-24">
        <div class="mx-auto max-w-7xl px-6">
            <div class="grid gap-10 lg:grid-cols-[.8fr_1.2fr]">
                <div>
                    <div class="mb-4 text-xs font-bold tracking-widest text-gold uppercase">Getting there</div>
                    <h2 class="font-display text-3xl leading-tight font-bold tracking-tight text-navy-deep sm:text-4xl">Well connected</h2>
                    <p class="mt-3 text-muted">NH 8, Ambience Island, DLF Phase 3, Sector 24, Gurugram, Haryana 122002</p>
                    <ul class="mt-6 divide-y divide-navy/10 rounded-2xl border border-navy/10 bg-white shadow-soft">
                        @foreach ($distances as [$place, $km])
                        <li class="flex items-center justify-between gap-4 px-5 py-4"><span class="font-semibold text-dark-navy">{{ $place }}</span><strong class="font-display text-navy">{{ $km }}</strong></li>
                        @endforeach
                    </ul>
                    <p class="mt-4 text-sm text-muted">Preferred delegate rates are available at partner hotels.</p>
                </div>
                <div>
                    <div class="mb-4 text-xs font-bold tracking-widest text-gold uppercase">On the property</div>
                    <div class="grid gap-4 sm:grid-cols-2">
                        @foreach ($amenities as [$icon, $title, $text])
                        <div class="rounded-2xl border border-navy/10 bg-white p-5 shadow-soft transition hover:-translate-y-1">
                            <span class="grid size-11 place-items-center rounded-xl bg-navy text-gold-light"><i class="fa-solid {{ $icon }}"></i></span>
                            <h3 class="mt-3 font-display font-bold text-navy-deep">{{ $title }}</h3>
                            <p class="mt-1 text-sm leading-relaxed text-muted">{{ $text }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Map --}}
    <section aria-label="Map of The Leela Ambience, Gurugram" class="leading-[0]">
        <iframe title="Map showing The Leela Ambience, Gurugram" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
            src="https://www.google.com/maps?q=The%20Leela%20Ambience%2C%20Gurugram&z=15&output=embed" class="block h-[420px] w-full border-0"></iframe>
    </section>

    {{-- Delhi --}}
    <section id="delhi" class="relative isolate overflow-hidden bg-gradient-to-b from-navy-deep via-navy to-[#041c38] py-24 text-white">
        {!! $glow !!}
        <div class="mx-auto max-w-7xl px-6">
            <div class="mx-auto mb-14 max-w-2xl text-center">
                <span class="inline-flex rounded-full border border-gold-light/40 bg-gold-light/15 px-3.5 py-1.5 text-xs font-bold tracking-wider text-gold-light uppercase">Explore Delhi</span>
                <h2 class="mt-5 font-display text-3xl leading-tight font-bold tracking-tight sm:text-4xl lg:text-5xl">Landmarks worth the detour</h2>
            </div>
            <div class="grid gap-5 md:grid-cols-2">
                @foreach ($monuments as [$icon, $title, $place, $text])
                <article class="rounded-3xl border border-white/15 bg-white/10 p-7 backdrop-blur transition hover:-translate-y-1 hover:border-gold-light/50">
                    <div class="flex items-center gap-4">
                        <span class="grid size-14 shrink-0 place-items-center rounded-xl bg-gold-light/15 text-xl text-gold-light"><i class="fa-solid {{ $icon }}"></i></span>
                        <div>
                            <h3 class="font-display text-xl font-bold">{{ $title }}</h3>
                            <span class="text-[.7rem] font-bold tracking-widest text-gold-light uppercase">{{ $place }}</span>
                        </div>
                    </div>
                    <p class="mt-4 text-sm leading-7 text-white/75">{{ $text }}</p>
                </article>
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.app>