<x-layouts.app title="Dashboard | DiCD 2026">

    <section
        class="relative isolate min-h-screen overflow-hidden bg-gradient-to-b from-navy-deep via-navy to-[#041c38] pt-36 pb-24 text-white">
        <div aria-hidden="true" class="pointer-events-none absolute inset-0 -z-10 overflow-hidden">
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

        <div class="mx-auto max-w-3xl px-6">
            @if (session('status'))
                <p class="mb-6 rounded-xl bg-gold-light/15 px-4 py-3 text-sm font-semibold text-gold-light">
                    {{ session('status') }}</p>
            @endif

            <h1 class="font-display text-4xl leading-tight font-bold tracking-tight sm:text-5xl">
                Hello,
                <em class="bg-gradient-to-r from-gold-light to-gold bg-clip-text text-transparent not-italic">
                    {{ auth()->user()->title }} {{ auth()->user()->name }}
                </em>
            </h1>

            <div class="mt-10 grid gap-4 sm:grid-cols-2">
                <a href="/profile"
                    class="flex items-center gap-4 rounded-3xl border border-white/15 bg-white/10 p-6 font-display text-lg font-bold backdrop-blur transition hover:-translate-y-0.5 hover:border-gold-light/50">
                    <i class="fa-solid fa-user text-gold-light"></i> Profile
                </a>

                <a href="/registration-payment"
                    class="flex items-center gap-4 rounded-3xl border border-white/15 bg-white/10 p-6 font-display text-lg font-bold backdrop-blur transition hover:-translate-y-0.5 hover:border-gold-light/50">
                    <i class="fa-solid fa-credit-card text-gold-light"></i> Registration Payment
                </a>

                <a href="#"
                    class="flex items-center gap-4 rounded-3xl border border-white/15 bg-white/10 p-6 font-display text-lg font-bold backdrop-blur transition hover:-translate-y-0.5 hover:border-gold-light/50">
                    <i class="fa-solid fa-file-lines text-gold-light"></i> Abstract Submission
                </a>

                <form method="POST" action="/logout">
                    @csrf
                    <button type="submit"
                        class="flex w-full items-center gap-4 rounded-3xl border border-white/15 bg-white/10 p-6 text-left font-display text-lg font-bold backdrop-blur transition hover:-translate-y-0.5 hover:border-red-300/60">
                        <i class="fa-solid fa-right-from-bracket text-red-300"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </section>

</x-layouts.app>
