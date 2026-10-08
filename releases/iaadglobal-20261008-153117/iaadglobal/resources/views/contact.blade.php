{{-- resources/views/contact.blade.php
     routes/web.php:  Route::view('/contact', 'contact'); --}}

<x-layouts.app title="Contact | DiCD 2026">

    @php
    $cards = [
    ['fa-building-columns', 'Congress Secretariat', 'International Association of Academic & Aesthetic Dermatology', '5/19, Vishal Khand, Gomti Nagar, Lucknow-10', []],
    ['fa-headset', 'Helpdesk', 'Dreamz Conference Management Pvt Ltd', '218, Ansal Majestic Tower, Vikaspuri, New Delhi - 110018', [
    ['mailto:info@dreamztravel.net', 'fa-envelope', 'info@dreamztravel.net'],
    ['tel:+919810558569', 'fa-phone', '+91 98105 58569'],
    ]],
    ['fa-location-dot', 'Venue', 'The Leela Ambience, Gurugram', 'NH 8, Ambience Island, DLF Phase 3, Sector 24, Gurugram, Haryana 122002', [
    ['/venue', 'fa-arrow-right', 'Venue & Delhi guide'],
    ]],
    ];
    @endphp

    {{-- hero --}}
    <section class="relative isolate overflow-hidden bg-gradient-to-b from-navy-deep via-navy to-[#041c38] pt-36 pb-24 text-white">
        <div aria-hidden="true" class="pointer-events-none absolute inset-0 -z-10 overflow-hidden">
            <div class="absolute inset-0 bg-[radial-gradient(rgba(255,255,255,.08)_1px,transparent_1px)] bg-[size:26px_26px] [mask-image:radial-gradient(ellipse_at_center,#000_30%,transparent_75%)]"></div>
            <div class="absolute -top-40 -right-32 size-[520px] rounded-full bg-[radial-gradient(closest-side,rgba(242,198,90,.20),transparent)]"></div>
            <div class="absolute -bottom-48 -left-40 size-[480px] rounded-full bg-[radial-gradient(closest-side,rgba(58,120,200,.30),transparent)]"></div>
        </div>
        <div class="mx-auto max-w-7xl px-6 text-center">
            <span class="inline-flex items-center gap-2 rounded-full border border-gold-light/40 bg-gold-light/15 px-3.5 py-1.5 text-xs font-bold tracking-wider text-gold-light uppercase motion-safe:animate-fade-up">
                <i class="fa-solid fa-envelope"></i> Get in touch
            </span>
            <h1 class="mt-5 font-display text-5xl leading-[1] font-bold tracking-tight sm:text-6xl lg:text-7xl motion-safe:animate-fade-up [animation-delay:80ms]">
                Contact <em class="bg-gradient-to-r from-gold-light to-gold bg-clip-text text-transparent not-italic">DiCD 2026</em>
            </h1>
            <p class="mx-auto mt-5 max-w-2xl text-lg leading-8 text-white/70 motion-safe:animate-fade-up [animation-delay:140ms]">
                Questions about registration, travel or the programme? The helpdesk team will get back to you.
            </p>
        </div>
    </section>

    {{-- contact cards --}}
    <section class="relative isolate overflow-hidden bg-gradient-to-b from-[#041c38] via-navy-deep to-navy pb-24 text-white">
        <div aria-hidden="true" class="pointer-events-none absolute inset-0 -z-10 overflow-hidden">
            <div class="absolute inset-0 bg-[radial-gradient(rgba(255,255,255,.07)_1px,transparent_1px)] bg-[size:26px_26px] [mask-image:radial-gradient(ellipse_at_center,#000_30%,transparent_75%)]"></div>
            <div class="absolute -top-72 -left-40 size-[480px] rounded-full bg-[radial-gradient(closest-side,rgba(58,120,200,.30),transparent)]"></div>
            <div class="absolute -right-32 -bottom-40 size-[420px] rounded-full bg-[radial-gradient(closest-side,rgba(242,198,90,.14),transparent)]"></div>
        </div>

        <div class="mx-auto grid max-w-7xl gap-5 px-6 md:grid-cols-3">
            @foreach ($cards as [$icon, $label, $name, $address, $links])
            <div class="rounded-3xl border border-white/15 bg-white/10 p-7 backdrop-blur transition hover:-translate-y-1 hover:border-gold-light/50">
                <div class="flex items-center gap-4">
                    <span class="grid size-12 shrink-0 place-items-center rounded-xl bg-gold-light/15 text-gold-light"><i class="fa-solid {{ $icon }}"></i></span>
                    <h2 class="text-xs font-bold tracking-widest text-gold-light uppercase">{{ $label }}</h2>
                </div>
                <strong class="mt-5 block font-display text-lg leading-snug">{{ $name }}</strong>
                <p class="mt-1.5 text-sm leading-relaxed text-white/65">{{ $address }}</p>
                @foreach ($links as [$href, $linkIcon, $text])
                <a href="{{ $href }}" class="mt-3 flex items-center gap-2 text-sm font-semibold text-white/80 transition hover:text-gold-light">
                    <i class="fa-solid {{ $linkIcon }} w-4 text-gold-light"></i> {{ $text }}
                </a>
                @endforeach
            </div>
            @endforeach
        </div>
    </section>

    {{-- map --}}
    <section aria-label="Map of The Leela Ambience, Gurugram" class="leading-[0]">
        <iframe title="Map showing The Leela Ambience, Gurugram" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
            src="https://www.google.com/maps?q=The%20Leela%20Ambience%2C%20Gurugram&z=15&output=embed" class="block h-[380px] w-full border-0"></iframe>
    </section>

</x-layouts.app>