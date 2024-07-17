<div>
    <div class="drawer-content w-full mx-auto p-5 lg:px-10 lg:py-5">
        <!-- MAIN CONTENT -->
        <div class="mt-20 md:w-96 mx-auto">
            <a href="/" wire:navigate="">
                <!-- Hidden when collapsed -->
                <div class="hidden-when-collapsed mb-8">
                    <div class="flex gap-2">
                        <img src="https://orange.mary-ui.com/images/orange.png" width="30" class="h-8">
                        <span
                            class="font-bold text-3xl mr-3 bg-gradient-to-r from-orange-500 to-purple-300 bg-clip-text text-transparent ">
                           e-Ping
                        </span>
                    </div>
                </div>

                <!-- Display when collapsed -->
                <div class="display-when-collapsed hidden mx-5 mt-4 lg:mb-6 h-[28px]">
                    <img src="https://flow.mary-ui.com/images/flow.png" width="30" class="h-8">
                </div>
            </a>
            <x-form wire:submit="save">
                <x-input label="Nom et prenom" wire:model="name" inline icon="o-user-circle" />
                <x-input label="Email" wire:model="email" inline icon="o-envelope" />
                <x-input label="Mot passe" wire:model="password" inline icon="o-lock-closed" type="password" />
                <x-input label="Comfirmer mot de passe" wire:model="confirm_password" inline icon="o-eye" type="password" />
                <x-slot:actions>
                    <x-button label="Valider" class="btn-primary" type="submit" spinner="save" />
                </x-slot:actions>
            </x-form>
        </div>

        <div class="flex mt-20 justify-center">
            <a href="/support-us" type="button"
                class="btn normal-case btn-ghost" wire:navigate="">

                <span class="block">
                    <svg class="inline w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17.25 6.75 22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3-4.5 16.5"></path>
                    </svg>
                </span><span class="">
                    e-plateforme
                </span>
            </a><a href="#" type="button"
                class="btn normal-case btn-ghost !text-pink-500" target="_blank">
                <span class="block">
                    <svg class="inline w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z">
                        </path>
                    </svg>
                </span><span class="">
                    Built with mecene
                </span>
            </a>
        </div>
    </div>
</div>
