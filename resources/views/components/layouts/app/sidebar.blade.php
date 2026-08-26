<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-900">
        <flux:sidebar sticky collapsible class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 hidden lg:flex">
            {{-- <flux:sidebar.toggle class="lg:hidden" icon="x-mark" /> --}}

            <div class="flex items-center justify-between p-0">
                <fLux:brand class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                    <x-app-logo />
                </fLux:brand>
                <flux:button x-data x-on:click="$flux.dark = ! $flux.dark" icon="moon" variant="subtle" aria-label="Toggle dark mode" class="cursor-pointer"/>
            </div>

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Platform')" class="grid">
                    @if(auth()->user()->is_admin)
                        <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
                    @endif
                    <flux:navlist.item icon="rectangle-group" :href="route('showItems')" :current="request()->routeIs('showItems')" wire:navigate>{{ __('Items') }}</flux:navlist.item>
                    @if(auth()->user()->is_admin)
                        <flux:navlist.item icon="adjustments-horizontal" href="/admin/default-items" :current="request()->is('admin/default-items')" wire:navigate>{{ __('Default Items') }}</flux:navlist.item>
                    @endif
                </flux:navlist.group>
                
                @auth
                    <flux:navlist.item icon="Envelope"
                        :href="route('invitations.show')" :current="request()->routeIs('invitations.show')" wire:navigate
                        badge="{{auth()->user()->invitations->count()}}" badge-color="red">
                        {{ __('Invitations') }}
                    </flux:navlist.item>

                    <livewire:lists.lists-sidebar />
                @endauth
            </flux:navlist>

            <flux:spacer />

            <!-- Desktop User Menu -->
            <flux:dropdown class="hidden lg:block" position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon:trailing="chevrons-up-down"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            {{-- <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" /> --}}

            {{-- <flux:spacer /> --}}

            <flux:dropdown position="top" align="start">
                <flux:profile :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                    avatar:color="auto" avatar:color:seed="{{auth()->user()->id}}"/>

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    @if(auth()->user()->is_admin)
                        <flux:menu.item :href="route('dashboard')" icon="home" wire:navigate>{{ __('Dashboard') }}</flux:menu.item>
                        <flux:menu.separator />
                    @endif

                    <flux:menu.item :href="route('showItems')" icon="rectangle-group" wire:navigate>{{ __('Items') }}</flux:menu.item>

                    <flux:menu.separator />
                    <flux:menu.item :href="route('invitations.show')" icon="Envelope" wire:navigate> {{ __('Invitations') }} </flux:menu.item>
                    <flux:menu.separator />
                    <flux:menu.submenu icon="bars-4" heading="{{__('My Lists')}}">
                        @foreach (auth()->user()->lists as $list)
                            <flux:menu.item :href="route('lists.manage', ['list'=>$list->id])" wire:navigate>
                                {{ $list->name }}
                            </flux:menu.item>
                        @endforeach
                        <flux:modal.trigger name="create-list">
                            <flux:button class="w-full" variant="ghost">{{__("Add new list")}}</flux:button>
                        </flux:modal.trigger>
                    </flux:menu.submenu>
                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
            <flux:spacer/>
            <flux:brand>
                <x-app-logo/>
            </flux:brand>
        </flux:header>

        {{ $slot }}

        @auth
            <livewire:lists.create-list />
        @endauth

        @fluxScripts
    </body>
</html>
