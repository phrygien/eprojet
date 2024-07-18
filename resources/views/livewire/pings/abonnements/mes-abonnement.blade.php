<?php

use Livewire\Volt\Component;
use Mary\Traits\Toast;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    use Toast;

    public function mount()
    {
        $user = Auth::user();
        $users = User::where('id', $user->id)->first();
        $roles = $users->roles;
    }

    public function renew()
    {
        $this->success('Action Saved !');
    }

    public function desabonnee()
    {
        $this->success('Data Saved !');
    }

}; ?>

<div>
    @can('edit-posts')
        <button>Edit Post</button>
    @endcan
    <x-header title="Mes abonnements" subtitle="Votres abonnement encours"></x-header>
    <div class="space-y-2">
        <div class="grid lg:grid-cols-3 md:grid-cols-1 gap-3">


            <div
                class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <div class="flex justify-between">
                    <div>
                        <a href="###" wire:navigate
                            class="text-xl font-bold hover:underline hover:text-amber-500">Mecene</a>
                    </div>
                    <div class="text-xs text-gray-500">
                        20/03/2022
                    </div>
                </div>
                <div class="flex items-end justify-between mt-4 space-x-1">
                    <p class="text-xs">Guard: <span class="font-semibold"> Laravel</span></p>
                    <div>
                        <x-button class="btn-primary btn-sm" icon="o-heart" wire:click='renew' />
                        <x-button label="" class="btn-sm" icon="o-hand-thumb-down" wire:click='desabonnee' />
                    </div>
                </div>
            </div>

            <div
                class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <div class="flex justify-between">
                    <div>
                        <a href="###" wire:navigate
                            class="text-xl font-bold hover:underline hover:text-amber-500">Mecene</a>
                    </div>
                    <div class="text-xs text-gray-500">
                        20/03/2022
                    </div>
                </div>
                <div class="flex items-end justify-between mt-4 space-x-1">
                    <p class="text-xs">Guard: <span class="font-semibold"> Laravel</span></p>
                    <div>
                        <x-button class="btn-primary btn-sm" link="#" icon="o-heart" />
                        <x-button label="" class="btn-sm" icon="o-hand-thumb-down" />
                    </div>
                </div>
            </div>

            <div
                class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <div class="flex justify-between">
                    <div>
                        <a href="###" wire:navigate
                            class="text-xl font-bold hover:underline hover:text-amber-500">Mecene</a>
                    </div>
                    <div class="text-xs text-gray-500">
                        20/03/2022
                    </div>
                </div>
                <div class="flex items-end justify-between mt-4 space-x-1">
                    <p class="text-xs">Guard: <span class="font-semibold"> Laravel</span></p>
                    <div>
                        <x-button class="btn-primary btn-sm" link="#" icon="o-heart" />
                        <x-button label="" class="btn-sm" icon="o-hand-thumb-down" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
