{{-- resources/views/register.blade.php
     routes/web.php:  Route::view('/register', 'register');
                      Route::post('/register', [RegisterController::class, 'store']); --}}

<x-layouts.app title="Register | DiCD 2026">

    @php
        // ---- delegate category pricing, from config/registration.php ----
        $tiers = config('registration.tiers');
        $now = now('Asia/Kolkata');
        $tier = collect($tiers)
            ->keys()
            ->first(
                fn($k) => !$tiers[$k]['ends'] ||
                    $now->lte(\Illuminate\Support\Carbon::parse($tiers[$k]['ends'], 'Asia/Kolkata')->endOfDay()),
            );

        $nonRes = collect(config('registration.packages.non_residential.rows'))->keyBy('category');
        $categories = ['Participants', 'SAARC AAD Member', 'Post Graduate Student'];
        $fees = [];
        foreach ($categories as $c) {
            $fees[$c] = $nonRes[$c]['prices'][$tier];
        }

        $titles = ['Dr.', 'Prof.', 'Mr.', 'Miss', 'Ms.'];
        $genders = ['Male', 'Female', 'Other'];
        $field =
            'w-full rounded-xl border border-white/15 bg-white/10 px-4 py-3 text-sm text-white placeholder-white/40 outline-none transition focus:border-gold-light focus:bg-white/15';
        $label = 'block text-xs font-bold tracking-wider text-white/70 uppercase';
        $card = 'rounded-3xl border border-white/15 bg-white/10 p-6 backdrop-blur sm:p-8';
        $req = '<span class="text-[#ff4d4f]" style="color:#ff4d4f">*</span>';
        $err = 'mt-1.5 block text-xs font-semibold tracking-normal text-red-300 normal-case';
    @endphp

    {{-- hero --}}
    <section
        class="relative isolate overflow-hidden bg-gradient-to-b from-navy-deep via-navy to-[#041c38] pt-36 pb-16 text-white">
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
        <div class="mx-auto max-w-7xl px-6 text-center">
            <span
                class="inline-flex items-center gap-2 rounded-full border border-gold-light/40 bg-gold-light/15 px-3.5 py-1.5 text-xs font-bold tracking-wider text-gold-light uppercase motion-safe:animate-fade-up">
                <i class="fa-solid fa-ticket"></i> {{ $tiers[$tier]['label'] }} rates · {{ $tiers[$tier]['note'] }}
            </span>
            <h1
                class="mt-5 font-display text-5xl leading-[1] font-bold tracking-tight sm:text-6xl lg:text-7xl motion-safe:animate-fade-up [animation-delay:80ms]">
                Register for <em
                    class="bg-gradient-to-r from-gold-light to-gold bg-clip-text text-transparent not-italic">DiCD
                    2026</em>
            </h1>
        </div>
        <div class="mt-6 flex justify-center">
            <a href="/login" class="btn-line !px-5 !py-2.5 !text-sm">
                Already registered? Login here <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>
    </section>

    <section
        class="relative isolate overflow-x-clip bg-gradient-to-b from-[#041c38] via-navy-deep to-navy pb-24 text-white">
        <div aria-hidden="true" class="pointer-events-none absolute inset-0 -z-10 overflow-hidden">
            <div
                class="absolute inset-0 bg-[radial-gradient(rgba(255,255,255,.07)_1px,transparent_1px)] bg-[size:26px_26px] [mask-image:radial-gradient(ellipse_at_center,#000_30%,transparent_75%)]">
            </div>
            <div
                class="absolute -top-72 -left-40 size-[480px] rounded-full bg-[radial-gradient(closest-side,rgba(58,120,200,.30),transparent)]">
            </div>
        </div>

        <form method="POST" action="/register" enctype="multipart/form-data" x-data="{ category: @js(old('category', '')), memberType: @js(old('member_type', '')) }"
            class="mx-auto max-w-3xl space-y-6 px-6">
            @csrf

            {{-- 1 · delegate category --}}
            <div class="{{ $card }}">
                <h2 class="mb-5 flex items-center gap-3 font-display text-xl font-bold"><span
                        class="grid size-8 place-items-center rounded-full bg-gold-light text-sm text-navy-deep">1</span>
                    Delegate category {!! $req !!}</h2>
                <div class="grid gap-3 sm:grid-cols-3">
                    @foreach ($categories as $c)
                        <label class="cursor-pointer rounded-2xl border-[1.5px] p-4 transition"
                            :class="category === '{{ $c }}' ? 'border-gold-light bg-gold-light/15' :
                                'border-white/15 bg-white/5 hover:border-gold-light/50'">
                            <input type="radio" name="category" value="{{ $c }}" x-model="category"
                                required class="sr-only">
                            <strong class="block font-display text-sm">{{ $c }}</strong>
                            <span
                                class="mt-1 block font-display text-lg text-gold-light">₹{{ number_format($fees[$c]) }}</span>
                        </label>
                    @endforeach
                </div>
                @error('category')
                    <span class="{{ $err }}">{{ $message }}</span>
                @enderror

                <label x-show="category === 'Post Graduate Student'" x-cloak x-transition
                    class="{{ $label }} mt-5">
                    Letter of HOD (required for PG students) {!! $req !!}
                    <input type="file" name="hod_letter" accept=".pdf,.jpg,.jpeg,.png"
                        :required="category === 'Post Graduate Student'"
                        class="{{ $field }} mt-2 normal-case file:mr-3 file:rounded-lg file:border-0 file:bg-gold-light file:px-3 file:py-1.5 file:text-xs file:font-bold file:text-navy-deep">
                    @error('hod_letter')
                        <span class="{{ $err }}">{{ $message }}</span>
                    @enderror
                </label>
            </div>

            {{-- 2 · personal details --}}
            <div class="{{ $card }}">
                <h2 class="mb-5 flex items-center gap-3 font-display text-xl font-bold"><span
                        class="grid size-8 place-items-center rounded-full bg-gold-light text-sm text-navy-deep">2</span>
                    Personal details</h2>

                <div class="grid gap-4 sm:grid-cols-2">
                    <label class="{{ $label }}">Title {!! $req !!}
                        <select name="title" required class="{{ $field }} mt-2 normal-case">
                            @foreach ($titles as $t)
                                <option class="text-dark-navy" @selected(old('title', 'Dr.') === $t)>{{ $t }}
                                </option>
                            @endforeach
                        </select>
                        @error('title')
                            <span class="{{ $err }}">{{ $message }}</span>
                        @enderror
                    </label>

                    <label class="{{ $label }}">Full name {!! $req !!}
                        <input type="text" name="name" placeholder="Enter your full name"
                            value="{{ old('name') }}" required autocomplete="name"
                            class="{{ $field }} mt-2 normal-case">
                        @error('name')
                            <span class="{{ $err }}">{{ $message }}</span>
                        @enderror
                    </label>

                    <label class="{{ $label }}">Age {!! $req !!}
                        <input type="number" name="age" placeholder="e.g. 35" value="{{ old('age') }}"
                            min="18" max="120" required class="{{ $field }} mt-2 normal-case">
                        @error('age')
                            <span class="{{ $err }}">{{ $message }}</span>
                        @enderror
                    </label>

                    <label class="{{ $label }}">Gender {!! $req !!}
                        <select name="gender" required class="{{ $field }} mt-2 normal-case">
                            <option value="" class="text-dark-navy">Select</option>
                            @foreach ($genders as $g)
                                <option class="text-dark-navy" @selected(old('gender') === $g)>{{ $g }}
                                </option>
                            @endforeach
                        </select>
                        @error('gender')
                            <span class="{{ $err }}">{{ $message }}</span>
                        @enderror
                    </label>

                    <label class="{{ $label }} sm:col-span-2">Institution / Hospital name
                        {!! $req !!}
                        <input type="text" name="institution" placeholder="Institution / hospital name"
                            value="{{ old('institution') }}" required class="{{ $field }} mt-2 normal-case">
                        @error('institution')
                            <span class="{{ $err }}">{{ $message }}</span>
                        @enderror
                    </label>
                </div>

                {{-- member type --}}
                <div class="mt-5">
                    <span class="{{ $label }}">Member type {!! $req !!}</span>
                    <div class="mt-2 grid gap-3 sm:grid-cols-2">
                        @foreach (['Plastic Surgeon', 'Dermatologist'] as $m)
                            <label class="cursor-pointer rounded-2xl border-[1.5px] p-4 text-sm font-bold transition"
                                :class="memberType === '{{ $m }}' ? 'border-gold-light bg-gold-light/15' :
                                    'border-white/15 bg-white/5 hover:border-gold-light/50'">
                                <input type="radio" name="member_type" value="{{ $m }}"
                                    x-model="memberType" required class="sr-only">
                                {{ $m }}
                            </label>
                        @endforeach
                    </div>
                    @error('member_type')
                        <span class="{{ $err }}">{{ $message }}</span>
                    @enderror

                    <label x-show="memberType === 'Dermatologist'" x-cloak x-transition
                        class="{{ $label }} mt-4">
                        IADVL membership no. <span class="font-normal text-white/50 normal-case">(optional)</span>
                        <input type="text" name="iadvl_no" placeholder="IADVL membership no."
                            value="{{ old('iadvl_no') }}" :disabled="memberType !== 'Dermatologist'"
                            class="{{ $field }} mt-2 normal-case">
                        @error('iadvl_no')
                            <span class="{{ $err }}">{{ $message }}</span>
                        @enderror
                    </label>

                    <label x-show="memberType === 'Plastic Surgeon'" x-cloak x-transition
                        class="{{ $label }} mt-4">
                        IAAPS / APSI membership no. <span
                            class="font-normal text-white/50 normal-case">(optional)</span>
                        <input type="text" name="iaaps_apsi_no" placeholder="IAAPS / APSI membership no."
                            value="{{ old('iaaps_apsi_no') }}" :disabled="memberType !== 'Plastic Surgeon'"
                            class="{{ $field }} mt-2 normal-case">
                        @error('iaaps_apsi_no')
                            <span class="{{ $err }}">{{ $message }}</span>
                        @enderror
                    </label>
                </div>
            </div>

            {{-- 3 · contact --}}
            <div class="{{ $card }}">
                <h2 class="mb-5 flex items-center gap-3 font-display text-xl font-bold"><span
                        class="grid size-8 place-items-center rounded-full bg-gold-light text-sm text-navy-deep">3</span>
                    Contact details</h2>

                <div class="grid gap-4 sm:grid-cols-2">
                    <label class="{{ $label }} sm:col-span-2">Address {!! $req !!}
                        <textarea name="address" placeholder="House / street / area" rows="2" required autocomplete="street-address"
                            class="{{ $field }} mt-2 normal-case">{{ old('address') }}</textarea>
                        @error('address')
                            <span class="{{ $err }}">{{ $message }}</span>
                        @enderror
                    </label>

                    <label class="{{ $label }}">City {!! $req !!}
                        <input type="text" name="city" placeholder="Enter city" value="{{ old('city') }}"
                            required autocomplete="address-level2" class="{{ $field }} mt-2 normal-case">
                        @error('city')
                            <span class="{{ $err }}">{{ $message }}</span>
                        @enderror
                    </label>

                    <label class="{{ $label }}">State {!! $req !!}
                        <input type="text" name="state" placeholder="Enter state" value="{{ old('state') }}"
                            required autocomplete="address-level1" class="{{ $field }} mt-2 normal-case">
                        @error('state')
                            <span class="{{ $err }}">{{ $message }}</span>
                        @enderror
                    </label>

                    <label class="{{ $label }}">Pincode {!! $req !!}
                        <input type="text" name="pincode" placeholder="6-digit pincode"
                            value="{{ old('pincode') }}" required inputmode="numeric" pattern="[0-9]{6}"
                            maxlength="6" autocomplete="postal-code" class="{{ $field }} mt-2 normal-case">
                        @error('pincode')
                            <span class="{{ $err }}">{{ $message }}</span>
                        @enderror
                    </label>

                    <label class="{{ $label }}">Phone number {!! $req !!}
                        <input type="tel" name="phone" placeholder="10-digit mobile number"
                            value="{{ old('phone') }}" required autocomplete="tel"
                            class="{{ $field }} mt-2 normal-case">
                        @error('phone')
                            <span class="{{ $err }}">{{ $message }}</span>
                        @enderror
                    </label>

                    <label class="{{ $label }} sm:col-span-2">Email {!! $req !!}
                        <input type="email" name="email" placeholder="you@example.com"
                            value="{{ old('email') }}" required autocomplete="email"
                            class="{{ $field }} mt-2 normal-case">
                        @error('email')
                            <span class="{{ $err }}">{{ $message }}</span>
                        @enderror
                    </label>
                </div>
            </div>

            {{-- 4 · account --}}
            <div class="{{ $card }}">
                <h2 class="mb-5 flex items-center gap-3 font-display text-xl font-bold"><span
                        class="grid size-8 place-items-center rounded-full bg-gold-light text-sm text-navy-deep">4</span>
                    Create password</h2>

                <div class="grid gap-4 sm:grid-cols-2">
                    <label class="{{ $label }}">Password {!! $req !!}
                        <div class="relative mt-2" x-data="{ show: false }">
                            <input :type="show ? 'text' : 'password'" name="password"
                                placeholder="Minimum 6 characters" required minlength="6"
                                autocomplete="new-password" class="{{ $field }} pr-12 normal-case">
                            <button type="button" @click="show = !show"
                                :aria-label="show ? 'Hide password' : 'Show password'"
                                class="absolute inset-y-0 right-0 px-4 text-white/60 transition hover:text-gold-light">
                                <i class="fa-solid" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                        @error('password')
                            <span class="{{ $err }}">{{ $message }}</span>
                        @enderror
                    </label>

                    <label class="{{ $label }}">Confirm password {!! $req !!}
                        <div class="relative mt-2" x-data="{ show: false }">
                            <input :type="show ? 'text' : 'password'" name="password_confirmation"
                                placeholder="Re-enter password" required minlength="6" autocomplete="new-password"
                                class="{{ $field }} pr-12 normal-case">
                            <button type="button" @click="show = !show"
                                :aria-label="show ? 'Hide password' : 'Show password'"
                                class="absolute inset-y-0 right-0 px-4 text-white/60 transition hover:text-gold-light">
                                <i class="fa-solid" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                    </label>
                </div>
            </div>

            <button type="submit" class="btn-fill w-full">
                Register <i class="fa-solid fa-arrow-right text-xs"></i>
            </button>
        </form>
    </section>

</x-layouts.app>
