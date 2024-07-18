<?php

use Livewire\Volt\Component;
use App\Models\User;
use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;

new class extends Component {
    #[Computed]
    public function user(): User|Authenticatable
    {
        return Auth::user();
    }

    public function logout(AuthManager $auth): void
    {
        $auth->logout();

        $this->redirect(
            url: route('pages:auth:login'),
        );
    }
}; ?>
    {{-- The navbar with `sticky` and `full-width` --}}
    <x-nav sticky>
        <x-slot:brand>
            {{-- Drawer toggle for "main-drawer" --}}
            <label for="main-drawer" class="lg:hidden mr-3">
                <x-icon name="o-bars-3" class="cursor-pointer" />
            </label>

            {{-- Brand --}}
            <div>
                <a href="/" wire:navigate="">
                    <div class="flex items-center gap-1">
                        <img src="https://orange.mary-ui.com/images/orange.png" width="30">
                        <span
                            class="font-bold text-3xl mr-3 bg-gradient-to-r from-amber-500 to-amber-300 bg-clip-text text-transparent ">
                            e-ping
                        </span>
                    </div>
                </a>
            </div>
        </x-slot:brand>

        {{-- Right side actions --}}
        <x-slot:actions>
            @guest()
            <x-button title="Pricing" label="Pricing" icon="o-banknotes" link="{{ route('pages:pings:mes_abonnements')}}" class="btn-ghost btn-sm " responsive />
            {{-- <x-button label="Se connecter" icon="o-user-circle" link="{{ route('pages:auth:login') }}" class="btn-ghost btn-sm" responsive /> --}}
            <x-button label="Get started" icon="o-user" link="{{ route('pages:auth:register')}}" class="btn-ghost btn-sm" responsive />
            @endguest

            @auth()
            <x-button title="Mes abonnements" label="Mes abonement" icon="o-heart" link="{{ route('pages:pings:mes_abonnements')}}" class="btn-ghost btn-sm text-amber-500" responsive />

            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                    <div class="w-10 rounded-full">
                    <img
                        alt="Tailwind CSS Navbar component"
                        src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.jpg" />
                    </div>
                </div>
                <ul
                    tabindex="0"
                    class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow">
                    <li>
                    <a class="justify-between">
                        Profile
                        <span class="badge">New</span>
                    </a>
                    </li>
                    <li><a>Parametres</a></li>
                    <li><a wire:click='logout'>Deconnecter</a></li>
                </ul>
                </div>
            @endauth
        </x-slot:actions>
    </x-nav>

{{-- <div class="bg-base-100 border-gray-100 border-b sticky top-0 z-10">
    <div class="flex items-center px-6 py-5 max-w-screen-2xl mx-auto">
        <div class="flex-1 flex items-center">
            <a href="/" wire:navigate="">
                <div class="flex items-center gap-1">
                    <img src="https://orange.mary-ui.com/images/orange.png" width="30">
                    <span
                        class="font-bold text-3xl mr-3 bg-gradient-to-r from-amber-500 to-amber-300 bg-clip-text text-transparent ">
                        e-ping
                    </span>
                </div>
            </a>
        </div>
        <div class="flex items-center gap-4">

            @guest()
            <div >
            <a href="{{ route('pages:auth:login') }}" wire:navigate class="btn normal-case btn-sm btn-ghost"
                type="button" >

                <!-- ICON -->
                <span class="block">
                    <svg class="inline w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z">
                        </path>
                    </svg>
                </span>

                <span class="hidden lg:block">
                    Se connecter
                </span>

            </a>
            <!--  Force tailwind compile tooltip classes   -->
            <span class="hidden">
                <span class="lg:tooltip lg:tooltip-left lg:tooltip-right lg:tooltip-bottom lg:tooltip-top"></span>
            </span>
        </div>

            <div wire:snapshot="{&quot;data&quot;:[],&quot;memo&quot;:{&quot;id&quot;:&quot;pxz52VTSJcIj51eb4lyq&quot;,&quot;name&quot;:&quot;store.user.menu&quot;,&quot;path&quot;:&quot;login&quot;,&quot;method&quot;:&quot;GET&quot;,&quot;children&quot;:[],&quot;scripts&quot;:[],&quot;assets&quot;:[],&quot;errors&quot;:[],&quot;locale&quot;:&quot;en&quot;},&quot;checksum&quot;:&quot;fa2fc83b7bcb2b0b9cd9cf30e1a1c0979201b68130bf152cb6d5b335ede8d53e&quot;}"
            wire:effects="[]" wire:id="pxz52VTSJcIj51eb4lyq">
            <a href="{{ route('pages:auth:register') }}" class="btn normal-case btn-sm btn-ghost"
                type="button" wire:navigate="">

                <!-- ICON -->
                <span class="block">
                    <svg class="inline w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z">
                        </path>
                    </svg>
                </span>

                <span class="hidden lg:block">
                    Inscription
                </span>

            </a>
            <!--  Force tailwind compile tooltip classes   -->
            <span class="hidden">
                <span class="lg:tooltip lg:tooltip-left lg:tooltip-right lg:tooltip-bottom lg:tooltip-top"></span>
            </span>
        </div>
            @endguest

            @auth()
            <x-button label="Pricing" link="###" class="btn-ghost btn-sm" responsive />
            <div>
            <details x-data="{open: false}" @click.outside="open = false" :open="open" class="dropdown">
                <!-- CUSTOM TRIGGER -->
                <summary x-ref="button" @click.prevent="open = !open" class="list-none">
                    <button wire:key="368267870307c1c5d5a1c0959ca99730" class="btn normal-case btn-ghost btn-sm"
                        type="button">

                        <span class="block">
                            <svg class="inline w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z">
                                </path>
                            </svg>
                        </span>

                        <span class="hidden lg:block">
                            Abonnements
                        </span>
                        <span class="badge badge-primary font-mono">0</span>

                    </button>

                    <!--  Force tailwind compile tooltip classes   -->
                    <span class="hidden">
                        <span
                            class="lg:tooltip lg:tooltip-left lg:tooltip-right lg:tooltip-bottom lg:tooltip-top"></span>
                    </span>
                </summary>

                <ul class="p-2 shadow menu z-[1] border border-base-200 bg-base-100 dark:bg-base-200 rounded-box whitespace-nowrap"
                    @click="open = false" x-anchor.bottom-end="$refs.button"
                    style="left: -23.188px; top: 32px; position: absolute;">
                    <div wire:key="dropdown-slot-7f7ed560503b9ebcf29ad350d4571dc4">
                        <div class="p-2">
                            <div class="inline-flex items-center gap-1">
                                <svg class="inline w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM18.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0z">
                                    </path>
                                </svg>
                                <div class="">
                                    Cart is empty
                                </div>
                            </div>
                        </div>
                    </div>
                </ul>
            </details>
        </div>

            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                    <div class="w-10 rounded-full">
                    <img
                        alt="Tailwind CSS Navbar component"
                        src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.jpg" />
                    </div>
                </div>
                <ul
                    tabindex="0"
                    class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow">
                    <li>
                    <a class="justify-between">
                        Profile
                        <span class="badge">New</span>
                    </a>
                    </li>
                    <li><a>Parametres</a></li>
                    <li><a wire:click='logout'>Deconnecter</a></li>
                </ul>
                </div>
            </div>
            @endauth
        </div>
    </div>
</div> --}}

