<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('هل نسيت كلمة مرورك؟ لا مشكلة. ما عليك سوى تزويدنا بعنوان بريدك الإلكتروني وسنرسل إليك رابط إعادة تعيين كلمة المرور لاختيار كلمة مرور جديدة.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form style="direction: rtl" method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('البريد الإلكتروني')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('رابط إعادة تعيين كلمة المرور للبريد الإلكتروني') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
