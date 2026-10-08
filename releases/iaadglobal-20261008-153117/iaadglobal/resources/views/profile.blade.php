<x-layouts.app title="Profile | DiCD 2026">

    @php
        $titles = ['Dr.', 'Prof.', 'Mr.', 'Miss', 'Ms.'];
        $genders = ['Male', 'Female', 'Other'];

        $field =
            'w-full rounded-xl border border-white/15 bg-white/10 px-4 py-3 text-sm text-white placeholder-white/40 outline-none transition focus:border-gold-light focus:bg-white/15';
        $locked =
            'w-full cursor-not-allowed rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white/60';
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
            <h1
                class="font-display text-5xl leading-[1] font-bold tracking-tight sm:text-6xl motion-safe:animate-fade-up">
                My <em
                    class="bg-gradient-to-r from-gold-light to-gold bg-clip-text text-transparent not-italic">Profile</em>
            </h1>
            <div class="mt-6 flex justify-center">
                <a href="/dashboard" class="btn-line !px-5 !py-2.5 !text-sm">
                    <i class="fa-solid fa-arrow-left text-xs"></i> Back to dashboard
                </a>
            </div>
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

        <div class="mx-auto max-w-3xl space-y-6 px-6">

            @if (session('status'))
                <p class="rounded-xl bg-gold-light/15 px-4 py-3 text-sm font-semibold text-gold-light">
                    {{ session('status') }}</p>
            @endif

            {{-- details --}}
            <form method="POST" action="/profile" x-data="{ memberType: @js(old('member_type', $user->member_type)) }" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="{{ $card }}">
                    <h2 class="mb-5 font-display text-xl font-bold">Account</h2>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <label class="{{ $label }}">Email
                            <input type="email" value="{{ $user->email }}" readonly
                                class="{{ $locked }} mt-2 normal-case">
                        </label>
                        <label class="{{ $label }}">Delegate category
                            <input type="text" value="{{ $user->category }}" readonly
                                class="{{ $locked }} mt-2 normal-case">
                        </label>
                    </div>
                    <p class="mt-3 text-xs text-white/55">Email and category can't be changed. Contact the helpdesk
                        if they need correcting.</p>
                </div>

                <div class="{{ $card }}">
                    <h2 class="mb-5 font-display text-xl font-bold">Personal details</h2>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <label class="{{ $label }}">Title {!! $req !!}
                            <select name="title" required class="{{ $field }} mt-2 normal-case">
                                @foreach ($titles as $t)
                                    <option class="text-dark-navy" @selected(old('title', $user->title) === $t)>{{ $t }}
                                    </option>
                                @endforeach
                            </select>
                            @error('title')
                                <span class="{{ $err }}">{{ $message }}</span>
                            @enderror
                        </label>

                        <label class="{{ $label }}">Full name {!! $req !!}
                            <input type="text" name="name" placeholder="Enter your full name"
                                value="{{ old('name', $user->name) }}" required
                                class="{{ $field }} mt-2 normal-case">
                            @error('name')
                                <span class="{{ $err }}">{{ $message }}</span>
                            @enderror
                        </label>

                        <label class="{{ $label }}">Age {!! $req !!}
                            <input type="number" name="age" placeholder="e.g. 35"
                                value="{{ old('age', $user->age) }}" min="18" max="120" required
                                class="{{ $field }} mt-2 normal-case">
                            @error('age')
                                <span class="{{ $err }}">{{ $message }}</span>
                            @enderror
                        </label>

                        <label class="{{ $label }}">Gender {!! $req !!}
                            <select name="gender" required class="{{ $field }} mt-2 normal-case">
                                @foreach ($genders as $g)
                                    <option class="text-dark-navy" @selected(old('gender', $user->gender) === $g)>{{ $g }}
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
                                value="{{ old('institution', $user->institution) }}" required
                                class="{{ $field }} mt-2 normal-case">
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
                                <label
                                    class="cursor-pointer rounded-2xl border-[1.5px] p-4 text-sm font-bold transition"
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
                                value="{{ old('iadvl_no', $user->iadvl_no) }}"
                                :disabled="memberType !== 'Dermatologist'"
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
                                value="{{ old('iaaps_apsi_no', $user->iaaps_apsi_no) }}"
                                :disabled="memberType !== 'Plastic Surgeon'"
                                class="{{ $field }} mt-2 normal-case">
                            @error('iaaps_apsi_no')
                                <span class="{{ $err }}">{{ $message }}</span>
                            @enderror
                        </label>
                    </div>
                </div>

                <div class="{{ $card }}">
                    <h2 class="mb-5 font-display text-xl font-bold">Contact details</h2>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <label class="{{ $label }} sm:col-span-2">Address {!! $req !!}
                            <textarea name="address" placeholder="House / street / area" rows="2" required
                                class="{{ $field }} mt-2 normal-case">{{ old('address', $user->address) }}</textarea>
                            @error('address')
                                <span class="{{ $err }}">{{ $message }}</span>
                            @enderror
                        </label>

                        <label class="{{ $label }}">City {!! $req !!}
                            <input type="text" name="city" placeholder="Enter city"
                                value="{{ old('city', $user->city) }}" required
                                class="{{ $field }} mt-2 normal-case">
                            @error('city')
                                <span class="{{ $err }}">{{ $message }}</span>
                            @enderror
                        </label>

                        <label class="{{ $label }}">State {!! $req !!}
                            <input type="text" name="state" placeholder="Enter state"
                                value="{{ old('state', $user->state) }}" required
                                class="{{ $field }} mt-2 normal-case">
                            @error('state')
                                <span class="{{ $err }}">{{ $message }}</span>
                            @enderror
                        </label>

                        <label class="{{ $label }}">Pincode {!! $req !!}
                            <input type="text" name="pincode" placeholder="6-digit pincode"
                                value="{{ old('pincode', $user->pincode) }}" required inputmode="numeric"
                                pattern="[0-9]{6}" maxlength="6" class="{{ $field }} mt-2 normal-case">
                            @error('pincode')
                                <span class="{{ $err }}">{{ $message }}</span>
                            @enderror
                        </label>

                        <label class="{{ $label }}">Phone number {!! $req !!}
                            <input type="tel" name="phone" placeholder="10-digit mobile number"
                                value="{{ old('phone', $user->phone) }}" required
                                class="{{ $field }} mt-2 normal-case">
                            @error('phone')
                                <span class="{{ $err }}">{{ $message }}</span>
                            @enderror
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn-fill w-full">
                    Save changes <i class="fa-solid fa-check text-xs"></i>
                </button>
            </form>

            {{-- password --}}
            <form method="POST" action="/profile/password" class="{{ $card }}">
                @csrf
                @method('PUT')

                <h2 class="mb-5 font-display text-xl font-bold">Change password</h2>

                <div class="space-y-4">
                    @foreach ([['current_password', 'Current password', 'Enter current password', 'current-password'], ['password', 'New password', 'Minimum 6 characters', 'new-password'], ['password_confirmation', 'Confirm new password', 'Re-enter new password', 'new-password']] as [$name, $text, $ph, $ac])
                        <label class="{{ $label }}">{{ $text }} {!! $req !!}
                            <div class="relative mt-2" x-data="{ show: false }">
                                <input :type="show ? 'text' : 'password'" name="{{ $name }}"
                                    placeholder="{{ $ph }}" required autocomplete="{{ $ac }}"
                                    class="{{ $field }} pr-12 normal-case">
                                <button type="button" @click="show = !show"
                                    :aria-label="show ? 'Hide password' : 'Show password'"
                                    class="absolute inset-y-0 right-0 px-4 text-white/60 transition hover:text-gold-light">
                                    <i class="fa-solid" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                                </button>
                            </div>
                            @error($name, 'password')
                                <span class="{{ $err }}">{{ $message }}</span>
                            @enderror
                        </label>
                    @endforeach
                </div>

                <button type="submit" class="btn-fill mt-6 w-full">
                    Update password <i class="fa-solid fa-lock text-xs"></i>
                </button>
            </form>
        </div>
    </section>

</x-layouts.app>
