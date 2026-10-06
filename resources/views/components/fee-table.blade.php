{{-- Usage: <x-fee-table package="non_residential" />
            <x-fee-table package="residential" :highlight-current="false" /> --}}
@props(['package', 'highlightCurrent' => true])

@php
    $pkg = config("registration.packages.$package");
    $tiers = config('registration.tiers');
    $now = now('Asia/Kolkata');

    // first tier whose end date hasn't passed
$current = null;
if ($highlightCurrent) {
    foreach ($tiers as $key => $tier) {
        if (
            !$tier['ends'] ||
            $now->lte(\Illuminate\Support\Carbon::parse($tier['ends'], 'Asia/Kolkata')->endOfDay())
        ) {
            $current = $key;
            break;
        }
    }
}
$money = fn($n) => '₹' . number_format($n);
@endphp

<div {{ $attributes->class('rounded-3xl border border-white/15 bg-white/10 p-6 backdrop-blur sm:p-8') }}>
    <h3 class="text-center font-display text-2xl font-bold text-white">{{ $pkg['title'] }}</h3>
    @if ($pkg['subtitle'])
        <p class="mt-1 text-center text-sm text-white/65">{{ $pkg['subtitle'] }}</p>
    @endif

    <div class="mt-6 overflow-x-auto">
        <table class="w-full min-w-[620px] border-separate border-spacing-y-2 text-left">
            <thead>
                <tr class="text-xs tracking-wider text-white/60 uppercase">
                    <th class="px-4 pb-2 font-bold">Category</th>
                    @foreach ($tiers as $key => $tier)
                        <th class="px-4 pb-2 font-bold {{ $key === $current ? 'text-gold-light' : '' }}">
                            {{ $tier['label'] }}
                            @if ($key === $current)
                                <span
                                    class="ml-1 rounded-full bg-gold-light px-2 py-0.5 text-[.6rem] text-navy-deep">Now</span>
                            @endif
                            <span
                                class="mt-0.5 block text-[.65rem] font-semibold tracking-normal normal-case text-white/50">{{ $tier['note'] }}</span>
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($pkg['rows'] as $row)
                    <tr class="text-sm">
                        <td class="rounded-l-xl bg-white/10 px-4 py-3.5 font-bold text-white">{{ $row['category'] }}
                        </td>
                        @if (isset($row['flat']))
                            <td colspan="{{ count($tiers) }}"
                                class="rounded-r-xl bg-white/10 px-4 py-3.5 text-center font-display text-lg font-bold text-gold-light">
                                {{ $money($row['flat']) }}</td>
                        @else
                            @foreach ($tiers as $key => $tier)
                                <td @class([
                                    'bg-white/10 px-4 py-3.5 font-display font-bold',
                                    'rounded-r-xl' => $loop->last,
                                    'text-gold-light' => $key === $current,
                                    'text-white/85' => $key !== $current,
                                ])>{{ $money($row['prices'][$key]) }}</td>
                            @endforeach
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <p class="mt-3 text-xs text-white/50">*GST {{ config('registration.gst') }}% will be applicable extra</p>
</div>
