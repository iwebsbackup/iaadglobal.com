<footer id="site-contact"
    class="relative isolate overflow-hidden bg-gradient-to-b from-[#041c38] to-[#030b16] pt-20 pb-8 text-white">

    <div aria-hidden="true" class="pointer-events-none absolute inset-0 -z-10 overflow-hidden">
        <div
            class="absolute inset-0 bg-[radial-gradient(rgba(255,255,255,.06)_1px,transparent_1px)] bg-[size:26px_26px] [mask-image:radial-gradient(ellipse_at_top,#000_20%,transparent_75%)]">
        </div>
        <div
            class="absolute -top-48 -right-32 size-[460px] rounded-full bg-[radial-gradient(closest-side,rgba(242,198,90,.12),transparent)]">
        </div>
        <div
            class="absolute -bottom-48 -left-40 size-[420px] rounded-full bg-[radial-gradient(closest-side,rgba(58,120,200,.22),transparent)]">
        </div>
    </div>

    <div class="mx-auto max-w-7xl px-6">

        {{-- CTA strip --}}
        <div
            class="mb-16 flex flex-wrap items-center justify-between gap-6 rounded-3xl border border-gold-light/30 bg-white/5 px-7 py-6 backdrop-blur">
            <div>
                <strong class="block font-display text-xl sm:text-2xl">Join us at DiCD 2026</strong>
                <span class="text-sm text-white/65">19–21 December 2026 · The Leela Ambience, Gurugram</span>
            </div>
            <a href="/registration" class="btn-fill">Register Now <i class="fa-solid fa-arrow-right text-xs"></i></a>
        </div>

        <div class="grid gap-12 lg:grid-cols-12">

            {{-- logos + social --}}
            <div class="lg:col-span-4">
                <div class="flex gap-2">
                    <img src="{{ asset('images/iaad-logo.png') }}" alt="IAAD logo"
                        class="h-12 w-auto rounded-lg bg-white px-2 py-1">
                    <img src="{{ asset('images/dicd-logo.png') }}" alt="DICD 2026 logo"
                        class="h-12 w-auto rounded-lg bg-white px-2 py-1">
                </div>

                <h3 class="mt-8 mb-4 text-xs font-bold tracking-widest text-gold-light uppercase">Visitors</h3>
                <a href="https://info.flagcounter.com/31OQ" class="block w-fit overflow-hidden rounded-lg bg-[#b37d0d]">
                    <img src="https://s01.flagcounter.com/count2/31OQ/bg_B37D0D/txt_FFFFFF/border_B37D0D/columns_3/maxflags_12/viewers_3/labels_0/pageviews_0/flags_0/percent_0/"
                        alt="Flag Counter" loading="lazy">
                </a>

                <div class="mt-8 flex gap-2">
                    @foreach ([['LinkedIn', 'fa-linkedin-in'], ['Instagram', 'fa-instagram'], ['YouTube', 'fa-youtube'], ['Facebook', 'fa-facebook-f']] as [$name, $icon])
                        <a href="#" aria-label="{{ $name }}"
                            class="grid size-10 place-items-center rounded-xl border border-white/15 bg-white/10 text-white/70 backdrop-blur transition hover:-translate-y-0.5 hover:border-gold-light/60 hover:text-gold-light">
                            <i class="fa-brands {{ $icon }}"></i>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- quick links --}}
            <div class="lg:col-span-2">
                <h3 class="mb-4 text-xs font-bold tracking-widest text-gold-light uppercase">Quick Links</h3>
                <ul class="space-y-2.5 text-sm text-white/65">
                    @foreach ([['/#home', 'Home'], ['/#about', 'About'], ['/#program', 'Program'], ['/committee', 'Committee'], ['/venue', 'Venue & Delhi'], ['/registration', 'Registration']] as [$href, $label])
                        <li><a href="{{ $href }}"
                                class="transition hover:text-gold-light">{{ $label }}</a></li>
                    @endforeach
                </ul>
            </div>

            {{-- contact --}}
            <div class="grid gap-5 sm:grid-cols-2 lg:col-span-6">
                <div class="rounded-2xl border border-white/10 bg-white/5 p-5 backdrop-blur">
                    <h3 class="mb-4 text-xs font-bold tracking-widest text-gold-light uppercase">DiCD 2026 Congress
                        Secretariat</h3>
                    <strong class="mb-1.5 block text-sm">International Association of Academic &amp; Aesthetic
                        Dermatology</strong>
                    <span class="text-sm text-white/65">5/19, Vishal Khand, Gomti Nagar, Lucknow-10</span>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-5 backdrop-blur">
                    <h3 class="mb-4 text-xs font-bold tracking-widest text-gold-light uppercase">DiCD 2026 Helpdesk</h3>
                    <strong class="mb-1.5 block text-sm">Dreamz Conference Management Pvt Ltd</strong>
                    <span class="mb-2 block text-sm text-white/65">218, Ansal Majestic Tower, Vikaspuri, New Delhi -
                        110018</span>
                    <a href="mailto:info@dreamztravel.net"
                        class="flex items-center gap-2 py-1 text-sm text-white/65 transition hover:text-gold-light">
                        <i class="fa-solid fa-envelope text-gold-light"></i> info@dreamztravel.net
                    </a>
                    <a href="tel:+919810558569"
                        class="flex items-center gap-2 py-1 text-sm text-white/65 transition hover:text-gold-light">
                        <i class="fa-solid fa-phone text-gold-light"></i> +91 98105 58569
                    </a>
                </div>
            </div>
        </div>

        <div class="mt-14 flex flex-wrap justify-between gap-2 border-t border-white/10 pt-6 text-sm text-white/45">
            <span>© <span x-data x-text="new Date().getFullYear()"></span> DICD. All rights reserved.</span>
            <span>Designed &amp; Maintained by Dreamz Conference Management Pvt. Ltd.</span>
        </div>
    </div>
</footer>

{{-- back to top --}}
<button type="button" x-data="{ show: false }" x-init="show = window.scrollY > 500"
    @scroll.window.passive="show = window.scrollY > 500" @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
    x-show="show" x-cloak x-transition.opacity aria-label="Back to top"
    class="fixed right-5 bottom-5 z-40 grid size-12 place-items-center rounded-2xl bg-gradient-to-br from-gold-light to-gold text-navy-deep shadow-lg shadow-gold/30 transition hover:-translate-y-0.5">
    <i class="fa-solid fa-arrow-up"></i>
</button>
