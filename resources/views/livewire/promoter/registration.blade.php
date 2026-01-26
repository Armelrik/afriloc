<div>
    @livewire('components.header')

    <div class="min-h-screen bg-gradient-to-br from-primary/5 to-accent/5 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ __('messages.registration.title') }}</h1>
            <p class="text-lg text-gray-600">{{ __('messages.registration.subtitle') }}</p>
        </div>

        <div class="bg-white rounded-lg shadow-xl overflow-hidden">
            <!-- Progress Bar -->
            <div class="bg-gradient-to-r from-primary to-accent px-8 py-6">
                <div class="flex justify-between items-center">
                    @for ($i = 1; $i <= 3; $i++)
                        <div class="flex flex-col items-center">
                            <div class="w-10 h-10 rounded-full {{ $step >= $i ? 'bg-white text-primary' : 'bg-white/30 text-white' }} flex items-center justify-center font-bold mb-2">
                                {{ $i }}
                            </div>
                            <span class="text-sm font-medium {{ $step >= $i ? 'text-white' : 'text-white/70' }}">
                                @if ($i === 1)
                                    {{ __('messages.registration.step1') }}
                                @elseif ($i === 2)
                                    {{ __('messages.registration.step2') }}
                                @else
                                    {{ __('messages.registration.step3') }}
                                @endif
                            </span>
                        </div>
                        @if ($i < 3)
                            <div class="flex-1 h-1 mx-4 {{ $step > $i ? 'bg-white' : 'bg-white/30' }}"></div>
                        @endif
                    @endfor
                </div>
            </div>

            <!-- Form Content -->
            <div class="p-8">
                @if (session()->has('error'))
                    <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                        {{ session('error') }}
                    </div>
                @endif

                <form wire:submit.prevent="{{ $step === 3 ? 'submit' : 'nextStep' }}">
                    <!-- Step 1: Account Information -->
                    @if ($step === 1)
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ __('messages.registration.account_info') }}</h2>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.registration.last_name') }} *</label>
                                    <input type="text" wire:model="nom" placeholder="{{ __('messages.registration.enter_last_name') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                    @error('nom') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.registration.first_name') }} *</label>
                                    <input type="text" wire:model="prenom" placeholder="{{ __('messages.registration.enter_first_name') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                    @error('prenom') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="mt-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.registration.email') }} *</label>
                                <input type="email" wire:model="email" placeholder="{{ __('messages.registration.enter_email') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                @error('email') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.registration.password') }} *</label>
                                    <input type="password" wire:model="password" placeholder="{{ __('messages.registration.min_8_chars') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                    @error('password') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.registration.confirm_password') }} *</label>
                                    <input type="password" wire:model="password_confirmation" placeholder="{{ __('messages.registration.repeat_password') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Step 2: Professional Information -->
                    @if ($step === 2)
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ __('messages.registration.professional_info') }}</h2>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.registration.company_name') }} *</label>
                                    <input type="text" wire:model="raison_sociale" placeholder="{{ __('messages.registration.legal_company_name') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                    @error('raison_sociale') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.registration.business_type') }} *</label>
                                    <select wire:model="type_structure" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                        <option value="">{{ __('messages.registration.select_type') }}</option>
                                        <option value="SARL">SARL</option>
                                        <option value="SA">SA</option>
                                        <option value="EIRL">EIRL</option>
                                        <option value="SCI">SCI</option>
                                        <option value="INDÉPENDANT">{{ __('messages.registration.self_employed') }}</option>
                                    </select>
                                    @error('type_structure') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="mt-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.registration.siret_number') }}</label>
                                <input type="text" wire:model="numero_siret" placeholder="{{ $randomSiret ?? '' }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                <p class="text-sm text-gray-500 mt-2">{{ __('messages.registration.siret_optional') }}</p>
                            </div>

                            <div class="mt-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.registration.professional_address') }} *</label>
                                <textarea wire:model="adresse_professionnelle" placeholder="{{ __('messages.registration.street_address') }}" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"></textarea>
                                @error('adresse_professionnelle') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.registration.city') }} *</label>
                                    <input type="text" wire:model="ville" placeholder="{{ __('messages.registration.city_name') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                    @error('ville') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.registration.phone') }} *</label>
                                    <input type="tel" wire:model="phone" placeholder="{{ __('messages.registration.phone_number') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                    @error('phone') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="mt-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.registration.whatsapp') }}</label>
                                <input type="tel" wire:model="whatsapp" placeholder="{{ __('messages.registration.whatsapp_optional') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                            </div>

                            <div class="mt-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.registration.company_description') }}</label>
                                <textarea wire:model="description" placeholder="{{ __('messages.registration.describe_company') }}" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"></textarea>
                            </div>
                        </div>
                    @endif

                    <!-- Step 3: Documents -->
                    @if ($step === 3)
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ __('messages.registration.required_documents') }}</h2>
                            <p class="text-gray-600 mb-6">{{ __('messages.registration.upload_documents_info') }}</p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- CNIB Recto -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.registration.cnib_front') }} *</label>
                                    <div class="relative">
                                        <input type="file" wire:model="cnib_recto" accept="image/*,.pdf" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                        <div class="px-4 py-6 border-2 border-dashed border-primary/30 rounded-lg text-center bg-primary/5 hover:bg-primary/10 transition">
                                            <svg class="mx-auto h-12 w-12 text-primary" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                <path d="M28 8H12a4 4 0 00-4 4v20a4 4 0 004 4h24a4 4 0 004-4V20m-8-12v12m0 0l-4-4m4 4l4-4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            <p class="mt-2 text-sm text-gray-600">{{ __('messages.registration.click_upload') }}</p>
                                        </div>
                                    </div>
                                    @error('cnib_recto') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                    @if ($cnib_recto)
                                        <p class="text-green-600 text-sm mt-2">✓ {{ __('messages.registration.file_uploaded') }}</p>
                                    @endif
                                </div>

                                <!-- CNIB Verso -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.registration.cnib_back') }} *</label>
                                    <div class="relative">
                                        <input type="file" wire:model="cnib_verso" accept="image/*,.pdf" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                        <div class="px-4 py-6 border-2 border-dashed border-primary/30 rounded-lg text-center bg-primary/5 hover:bg-primary/10 transition">
                                            <svg class="mx-auto h-12 w-12 text-primary" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                <path d="M28 8H12a4 4 0 00-4 4v20a4 4 0 004 4h24a4 4 0 004-4V20m-8-12v12m0 0l-4-4m4 4l4-4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            <p class="mt-2 text-sm text-gray-600">{{ __('messages.registration.click_upload') }}</p>
                                        </div>
                                    </div>
                                    @error('cnib_verso') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                    @if ($cnib_verso)
                                        <p class="text-green-600 text-sm mt-2">✓ {{ __('messages.registration.file_uploaded') }}</p>
                                    @endif
                                </div>

                                <!-- Photo Promoteur -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.registration.photo') }} *</label>
                                    <div class="relative">
                                        <input type="file" wire:model="photo_promoteur" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                        <div class="px-4 py-6 border-2 border-dashed border-primary/30 rounded-lg text-center bg-primary/5 hover:bg-primary/10 transition">
                                            <svg class="mx-auto h-12 w-12 text-primary" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                <path d="M28 8H12a4 4 0 00-4 4v20a4 4 0 004 4h24a4 4 0 004-4V20m-8-12v12m0 0l-4-4m4 4l4-4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            <p class="mt-2 text-sm text-gray-600">{{ __('messages.registration.click_upload') }}</p>
                                        </div>
                                    </div>
                                    @error('photo_promoteur') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                    @if ($photo_promoteur)
                                        <p class="text-green-600 text-sm mt-2">✓ {{ __('messages.registration.file_uploaded') }}</p>
                                    @endif
                                </div>

                                <!-- Justificatif Domicile -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.registration.proof_residence') }} *</label>
                                    <div class="relative">
                                        <input type="file" wire:model="justificatif_domicile" accept="image/*,.pdf" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                        <div class="px-4 py-6 border-2 border-dashed border-primary/30 rounded-lg text-center bg-primary/5 hover:bg-primary/10 transition">
                                            <svg class="mx-auto h-12 w-12 text-primary" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                <path d="M28 8H12a4 4 0 00-4 4v20a4 4 0 004 4h24a4 4 0 004-4V20m-8-12v12m0 0l-4-4m4 4l4-4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            <p class="mt-2 text-sm text-gray-600">{{ __('messages.registration.click_upload') }}</p>
                                        </div>
                                    </div>
                                    @error('justificatif_domicile') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                    @if ($justificatif_domicile)
                                        <p class="text-green-600 text-sm mt-2">✓ {{ __('messages.registration.file_uploaded') }}</p>
                                    @endif
                                </div>

                                <!-- Registre Commerce -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.registration.business_registration') }} *</label>
                                    <div class="relative">
                                        <input type="file" wire:model="registre_commerce" accept="image/*,.pdf" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                        <div class="px-4 py-6 border-2 border-dashed border-primary/30 rounded-lg text-center bg-primary/5 hover:bg-primary/10 transition">
                                            <svg class="mx-auto h-12 w-12 text-primary" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                <path d="M28 8H12a4 4 0 00-4 4v20a4 4 0 004 4h24a4 4 0 004-4V20m-8-12v12m0 0l-4-4m4 4l4-4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            <p class="mt-2 text-sm text-gray-600">{{ __('messages.registration.click_upload') }}</p>
                                        </div>
                                    </div>
                                    @error('registre_commerce') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                    @if ($registre_commerce)
                                        <p class="text-green-600 text-sm mt-2">✓ {{ __('messages.registration.file_uploaded') }}</p>
                                    @endif
                                </div>

                                <!-- Attestation Fiscale -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.registration.tax_certificate') }} *</label>
                                    <div class="relative">
                                        <input type="file" wire:model="attestation_fiscale" accept="image/*,.pdf" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                        <div class="px-4 py-6 border-2 border-dashed border-primary/30 rounded-lg text-center bg-primary/5 hover:bg-primary/10 transition">
                                            <svg class="mx-auto h-12 w-12 text-primary" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                <path d="M28 8H12a4 4 0 00-4 4v20a4 4 0 004 4h24a4 4 0 004-4V20m-8-12v12m0 0l-4-4m4 4l4-4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            <p class="mt-2 text-sm text-gray-600">{{ __('messages.registration.click_upload') }}</p>
                                        </div>
                                    </div>
                                    @error('attestation_fiscale') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                    @if ($attestation_fiscale)
                                        <p class="text-green-600 text-sm mt-2">✓ {{ __('messages.registration.file_uploaded') }}</p>
                                    @endif
                                </div>

                                <!-- Certificat Propriété -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.registration.ownership_certificate') }} ({{ __('messages.common.optional') }})</label>
                                    <div class="relative">
                                        <input type="file" wire:model="certificat_propriete" accept="image/*,.pdf" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                        <div class="px-4 py-6 border-2 border-dashed border-gray-300 rounded-lg text-center bg-gray-50 hover:bg-gray-100 transition">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                <path d="M28 8H12a4 4 0 00-4 4v20a4 4 0 004 4h24a4 4 0 004-4V20m-8-12v12m0 0l-4-4m4 4l4-4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            <p class="mt-2 text-sm text-gray-600">{{ __('messages.registration.click_upload') }}</p>
                                        </div>
                                    </div>
                                    @if ($certificat_propriete)
                                        <p class="text-green-600 text-sm mt-2">✓ {{ __('messages.registration.file_uploaded') }}</p>
                                    @endif
                                </div>

                                <!-- Assurance RC -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.registration.liability_insurance') }} ({{ __('messages.common.optional') }})</label>
                                    <div class="relative">
                                        <input type="file" wire:model="assurance_rc" accept="image/*,.pdf" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                        <div class="px-4 py-6 border-2 border-dashed border-gray-300 rounded-lg text-center bg-gray-50 hover:bg-gray-100 transition">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                <path d="M28 8H12a4 4 0 00-4 4v20a4 4 0 004 4h24a4 4 0 004-4V20m-8-12v12m0 0l-4-4m4 4l4-4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            <p class="mt-2 text-sm text-gray-600">{{ __('messages.registration.click_upload') }}</p>
                                        </div>
                                    </div>
                                    @if ($assurance_rc)
                                        <p class="text-green-600 text-sm mt-2">✓ {{ __('messages.registration.file_uploaded') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Navigation Buttons -->
                    <div class="flex justify-between mt-8 pt-6 border-t border-gray-200">
                        @if ($step > 1)
                            <button type="button" wire:click="previousStep" class="px-8 py-3 bg-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-400 transition">
                                ← {{ __('messages.registration.previous') }}
                            </button>
                        @else
                            <div></div>
                        @endif

                        <button type="submit" class="px-8 py-3 bg-gradient-to-r from-primary to-accent text-white rounded-lg font-semibold hover:shadow-lg transition">
                            {{ $step === 3 ? __('messages.registration.submit') . ' →' : __('messages.registration.next') . ' →' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Info Box -->
        <div class="mt-8 bg-primary/5 border border-primary/20 rounded-lg p-6">
            <h3 class="font-semibold text-gray-900 mb-2">{{ __('messages.registration.information') }}</h3>
            <ul class="text-sm text-gray-700 space-y-1">
                <li>✓ {{ __('messages.registration.info1') }}</li>
                <li>✓ {{ __('messages.registration.info2') }}</li>
                <li>✓ {{ __('messages.registration.info3') }}</li>
                <li>✓ {{ __('messages.registration.info4') }}</li>
            </ul>
        </div>
    </div>
    </div>

    @livewire('components.footer')
</div>