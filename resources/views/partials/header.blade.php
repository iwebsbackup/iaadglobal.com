{{-- STICKY HEADER: to make it sticky again, change "absolute" to "fixed" on the <header> tag
     and on the <nav> tag (2 places), and swap :class on <header> back to:
     (scrolled || open) ? 'border-b border-white/10 bg-navy-deep/90 shadow-lg shadow-black/20 backdrop-blur-md' : 'border-b border-transparent bg-transparent'
     with x-data="{ scrolled: false, open: false }", x-init="scrolled = window.scrollY > 24"
     and @scroll.window.passive="scrolled = window.scrollY > 24".
     Also set the sticky bars back to top-20 lg:top-34. --}}
<header x-data="{ open: false }" @keydown.escape.window="open = false"
    @resize.window="if (window.innerWidth >= 1024) open = false"
    :class="open ? 'border-b border-white/10 bg-navy-deep' : 'border-b border-transparent bg-transparent'"
    class="absolute inset-x-0 top-0 z-50">

    <div class="mx-auto flex h-20 max-w-7xl items-center justify-between gap-4 px-6 lg:h-34">
        {{-- logos --}}
        <a href="/" class="flex items-center gap-3 sm:gap-5">
            <img src="{{ asset('images/iaad-logo.png') }}" alt="IAAD"
                class="h-12 w-auto rounded-lg shadow sm:h-16 lg:h-28">
            <img src="{{ asset('images/dicd-logo.png') }}" alt="DiCD 2026"
                class="h-12 w-auto rounded-lg shadow sm:h-16 lg:h-28">
        </a>

        {{-- menu --}}
        <nav :class="open ? 'block' : 'hidden'"
            class="absolute inset-x-0 top-20 max-h-[calc(100svh-5rem)] overflow-y-auto border-t border-white/10 bg-navy-deep px-6 pb-6 shadow-lg lg:static lg:block lg:max-h-none lg:overflow-visible lg:border-0 lg:bg-transparent lg:p-0 lg:shadow-none">
            <ul class="flex flex-col lg:flex-row lg:items-center lg:gap-7">
                <li><a href="/"
                        class="block py-3 font-bold text-white transition hover:text-gold-light lg:py-0">Home</a></li>

                <!-- <li class="relative" x-data="{ dd: false }" @click.outside="dd = false" @keydown.escape.window="dd = false">
                    <button type="button" @click="dd = !dd" :aria-expanded="dd"
                        class="flex w-full items-center justify-between gap-2 py-3 font-bold text-white transition hover:text-gold-light lg:w-auto lg:py-0">
                        About
                        <i class="fa-solid fa-chevron-down text-[.6rem] transition" :class="dd && 'rotate-180'"></i>
                    </button>

                    <ul x-show="dd" x-cloak x-transition.opacity
                        class="rounded-xl border border-white/15 bg-white/10 p-2 lg:absolute lg:top-full lg:left-0 lg:mt-3 lg:min-w-56 lg:bg-navy-deep lg:shadow-card lg:backdrop-blur-md">
                        <li><a href="/committee" @click="dd = false" class="block rounded-lg px-3 py-2 text-sm font-semibold text-white/85 transition hover:bg-white/10 hover:text-gold-light">Organizing Committee</a></li>
                        <li><a href="/venue" @click="dd = false" class="block rounded-lg px-3 py-2 text-sm font-semibold text-white/85 transition hover:bg-white/10 hover:text-gold-light">Venue &amp; Delhi</a></li>
                    </ul>
                </li> -->

                <li><a href="/venue"
                        class="block py-3 font-bold text-white transition hover:text-gold-light lg:py-0">Venue</a></li>
                <li><a href="/committee"
                        class="block py-3 font-bold text-white transition hover:text-gold-light lg:py-0">Committee</a>
                </li>
                <li><a href="/#highlights"
                        class="block py-3 font-bold text-white transition hover:text-gold-light lg:py-0">Highlights</a>
                </li>
                <li><a href="/contact"
                        class="block py-3 font-bold text-white transition hover:text-gold-light lg:py-0">Contact</a>
                </li>
            </ul>
            <a href="/registration" class="btn-fill mt-3 w-full lg:hidden">Register Now</a>
        </nav>

        {{-- right side --}}
        <div class="flex items-center gap-3">
            <a href="/registration" class="btn-fill hidden !px-5 !py-2.5 !text-sm lg:inline-flex">Register Now</a>
            <button type="button" @click="open = !open" :aria-expanded="open" aria-label="Toggle navigation"
                class="p-1 text-2xl leading-none text-white lg:hidden">
                <i class="fa-solid" :class="open ? 'fa-xmark' : 'fa-bars'"></i>
            </button>
        </div>
    </div>
</header>