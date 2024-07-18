<?php

use Livewire\Volt\Component;
use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Mary\Traits\Toast;
new class extends Component {
    use Toast;

    #[Validate(['required','email','max:255'])]
    public string $email = '';

    #[Validate(['required','string','max:255'])]
    public string $password = '';

    public function submit(AuthManager $auth): void
    {
        $this->validate();

        if ( ! $auth->attempt(['email' => $this->email, 'password' => $this->password])) {

            $this->error('Login successful.', 'You are now logged in.', position: 'toast-top-right');
            throw ValidationException::withMessages([
                'email' => 'Failed to authenticate you.',
            ]);
        }

        $this->success('Login successful.', 'You are not logged in.', position: 'toast-top-right');

        $this->redirect(
            url: route('pages:dashboard'),
        );
    }

}; ?>

<div>
    <div class="drawer-content w-full mx-auto p-5 lg:p-10">
        <!-- MAIN CONTENT -->
        <div class="flex">
            <div class="mx-auto w-96">
                <img src="https://orange.mary-ui.com/images/login.png" width="96" class="mx-auto mb-8">
                <x-form wire:submit="submit">
                    <x-input label="Email" wire:model="email" icon="o-envelope" inline />
                    <x-input label="Mot de passe" wire:model="password" type="password" icon="o-lock-closed" inline />

                    <x-slot:actions>
                        <x-button label="Login" class="btn-primary" type="submit" spinner="submit" icon="o-paper-airplane" />
                    </x-slot:actions>
                </x-form>
                {{-- <p class="mt-3">Pas de compte? inscrivez vous gratuitement <a href="{{ route('pages:auth:register') }}" class="link link-secondary" wire:navigate>ici</a></p> --}}
            </div>
        </div>


        <div class="flex mt-20 mx-auto w-96 text-center">
            <a href="/support-us" wire:key="00780c6e001be6437dd1c8fe3e7c0f7a" class="btn normal-case btn-ghost"
                type="button" wire:navigate="">

                <!-- SPINNER LEFT -->

                <!-- ICON -->
                <span class="block">
                    <svg class="inline w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5"></path>
                    </svg>
                </span>

                <!-- LABEL / SLOT -->
                <span class="">
                    Source code
                </span>

                <!-- ICON RIGHT -->

                <!-- SPINNER RIGHT -->

            </a>

            <!--  Force tailwind compile tooltip classes   -->
            <span class="hidden">
                <span class="lg:tooltip lg:tooltip-left lg:tooltip-right lg:tooltip-bottom lg:tooltip-top"></span>
            </span> <a href="Built with MaryUI" wire:key="7d3df731b46ee3bf901beda1a711ec22"
                class="btn normal-case btn-ghost !text-pink-500" type="button" target="_blank">

                <!-- SPINNER LEFT -->

                <!-- ICON -->
                <span class="block">
                    <svg class="inline w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z">
                        </path>
                    </svg>
                </span>

                <!-- LABEL / SLOT -->
                <span class="">
                    Built with MaryUI
                </span>

                <!-- ICON RIGHT -->

                <!-- SPINNER RIGHT -->

            </a>

            <!--  Force tailwind compile tooltip classes   -->
            <span class="hidden">
                <span class="lg:tooltip lg:tooltip-left lg:tooltip-right lg:tooltip-bottom lg:tooltip-top"></span>
            </span>
        </div>
    </div>
</div>
