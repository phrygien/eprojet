<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="acid">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title.' - '.config('app.name') : config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen font-sans antialiased bg-base-200/50 dark:bg-base-200">

    {{-- NAVBAR mobile only --}}
    <x-nav sticky class="lg:hidden">
        <x-slot:brand>
            <x-app-brand />
        </x-slot:brand>
        <x-slot:actions>
            <label for="main-drawer" class="mr-3 lg:hidden">
                <x-icon name="o-bars-3" class="cursor-pointer" />
            </label>
        </x-slot:actions>
    </x-nav>

    {{-- MAIN --}}
    <x-main full-width>
        {{-- SIDEBAR --}}
        <x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-100 lg:bg-inherit">

            {{-- BRAND --}}
            <x-app-brand class="pt-3 ml-5" />

            {{-- MENU --}}
            <x-menu title="{{ null }}" activate-by-route>

                @if(auth()->check())
                    <x-menu-separator />

                    <livewire:tenants.user-menu />

                    <x-menu-separator />
                @endif

                <x-menu-item title="Dashboard" icon="o-sparkles" link="/" />
                <x-menu-sub title="Settings" icon="o-cog-6-tooth">
                    <x-menu-item title="Profile" icon="o-wifi" link="{{ route('pages:tenants:settings:profile') }}" />
                    <x-menu-item title="Tenant" icon="o-archive-box" link="####" />
                </x-menu-sub>
                <x-menu-item title="Gestion des classes" icon="o-beaker" link="####" />
                <x-menu-item title="Gestion des sections" icon="o-archive-box" link="####" />
                <x-menu-sub title="Gestion des étudiants" icon="o-user-group">
                    <x-menu-item title="Inscription en ligne" icon="o-book-open" link="{{ route('pages:tenants:settings:profile') }}" />
                    <x-menu-item title="Suivi statut inscription" icon="o-archive-box" link="####" />
                </x-menu-sub>

                <x-menu-sub title="Gestion des cours" icon="o-clipboard-document-list">
                    <x-menu-item title="Matières" icon="o-calendar" link="{{ route('pages:tenants:settings:profile') }}" />
                    <x-menu-item title="Emplois du temps" icon="o-archive-box" link="####" />
                </x-menu-sub>

                <x-menu-sub title="Suvi absences & retard" icon="o-calendar">
                    <x-menu-item title="Suivi des absences" icon="o-calendar" link="{{ route('pages:tenants:settings:profile') }}" />
                    <x-menu-item title="Suivi des retards" icon="o-archive-box" link="####" />
                </x-menu-sub>

                <x-menu-sub title="Gestion des enseignants" icon="o-user">
                    <x-menu-item title="Enseignants" icon="o-calendar" link="{{ route('pages:tenants:settings:profile') }}" />
                    <x-menu-item title="Affectation enseignant" icon="o-archive-box" link="####" />
                </x-menu-sub>

            </x-menu>
        </x-slot:sidebar>

        {{-- The `$slot` goes here --}}
        <x-slot:content>
            {{ $slot }}
        </x-slot:content>
    </x-main>

    {{--  TOAST area --}}
    <x-toast />
</body>
</html>
