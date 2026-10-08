@props(['name', 'role' => null, 'file' => null])

@php
    // photo: images/faculty/dr.{slug}.png unless $file is given (without extension)
    $slug = $file ?? 'dr.' . \Illuminate\Support\Str::slug($name);

    // initials fallback: first + last word, skipping titles like "Maj." / "S.M."
    $words = array_values(array_filter(explode(' ', $name), fn($w) => $w !== '' && !str_contains($w, '.')));
    $initials = strtoupper(mb_substr($words[0] ?? '', 0, 1) . mb_substr(end($words) ?: '', 0, 1));

    $roleLines = $role ? explode('|', $role) : [];
@endphp

<article
    class="w-44 rounded-3xl border border-navy/10 bg-white p-5 text-center shadow-soft transition hover:-translate-y-1 sm:w-52">
    <div
        class="relative mx-auto grid size-28 place-items-center overflow-hidden rounded-t-full rounded-b-2xl border-2 border-gold-light bg-light-blue font-display text-3xl font-bold text-navy sm:size-32">
        <span aria-hidden="true">{{ $initials }}</span>
        <img src="{{ asset('images/faculty/' . $slug . '.png') }}" alt="Dr. {{ $name }}" loading="lazy"
            onerror="this.remove()" class="absolute inset-0 size-full object-cover">
    </div>

    <h4 class="mt-4 font-display text-base leading-snug font-bold text-navy-deep">Dr. {{ $name }}</h4>

    @foreach ($roleLines as $line)
        <p class="mt-0.5 text-xs leading-snug font-semibold text-muted">{{ $line }}</p>
    @endforeach
</article>
