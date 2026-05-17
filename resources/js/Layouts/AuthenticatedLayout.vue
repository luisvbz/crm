<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

const sidebarOpen = ref(false);
</script>

<template>
    <div class="min-h-screen flex text-neutral-800 bg-primary-50">

        <!-- Sidebar / Offcanvas mobile -->
        <aside
            :class="['fixed inset-y-0 left-0 z-50 w-64 bg-primary-900 text-white transition-transform duration-300 ease-in-out md:relative md:translate-x-0 shadow-lg md:shadow-none', sidebarOpen ? 'translate-x-0' : '-translate-x-full']">
            <div class="flex h-[60px] shrink-0 items-center px-6 bg-primary-950 border-b border-white/10">
                <Link :href="route('dashboard')" class="flex items-center gap-3">
                    <ApplicationLogo class="h-8 w-auto fill-current text-white" />
                    <span class="font-bold text-lg tracking-wide">CRM<span class="text-primary-400">Pro</span></span>
                </Link>
            </div>

            <div class="py-6 px-4 space-y-1">
                <p class="text-label text-white/50 px-2 mb-2">Principal</p>

                <Link :href="route('dashboard')"
                    :class="['flex items-center gap-3 px-3 py-2.5 rounded-md font-medium text-sm transition', route().current('dashboard') ? 'bg-primary-500 text-white shadow-primary' : 'text-white/70 hover:bg-white/10 hover:text-white']">
                    <svg class="w-5 h-5 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    Dashboard
                </Link>

            </div>
        </aside>

        <!-- Overlay for mobile sidebar -->
        <div v-if="sidebarOpen" @click="sidebarOpen = false"
            class="fixed inset-0 bg-primary-950/60 z-40 md:hidden backdrop-blur-sm transition-opacity"></div>

        <!-- Main Column -->
        <div class="flex flex-1 flex-col overflow-hidden">
            <!-- Topbar -->
            <header
                class="flex h-[60px] shrink-0 items-center justify-between border-b border-neutral-200 bg-white/70 backdrop-blur-md px-4 shadow-sm md:px-8 z-30">

                <!-- Mobile hamburger -->
                <button @click="sidebarOpen = true"
                    class="md:hidden p-2 text-neutral-500 hover:text-primary-500 transition">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <div class="hidden md:flex flex-1 items-center gap-4">
                    <!-- Search Placeholder -->
                    <div class="relative w-64 max-w-sm">
                        <input type="text" class="input pl-10 h-9 bg-neutral-50" placeholder="Buscar..." />
                        <svg class="absolute left-3 top-2.5 h-4 w-4 text-neutral-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>

                <div class="ms-3 relative flex items-center gap-3">
                    <Dropdown align="right" width="48">
                        <template #trigger>
                            <button type="button"
                                class="flex items-center gap-2 rounded-full bg-primary-50/50 px-2 py-1 text-sm font-medium text-primary-900 transition hover:bg-primary-100 border border-primary-100 shadow-sm">
                                <div
                                    class="w-8 h-8 rounded-full bg-primary-600 text-white flex items-center justify-center font-bold tracking-tight shadow-sm text-xs">
                                    {{ $page.props.auth.user.name.charAt(0).toUpperCase() }}
                                </div>
                                <span class="hidden md:block font-semibold pr-1">{{ $page.props.auth.user.name }}</span>
                                <svg class="h-4 w-4 text-primary-400 hidden md:block" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </template>

                        <template #content>
                            <div class="px-4 py-3 border-b border-neutral-100 mb-1 bg-neutral-50/50">
                                <p class="text-sm font-semibold text-neutral-900">{{ $page.props.auth.user.name }}</p>
                                <p class="text-xs text-neutral-500 truncate">{{ $page.props.auth.user.email }}</p>
                            </div>
                            <DropdownLink :href="route('profile.edit')">
                                Mi Perfil
                            </DropdownLink>
                            <DropdownLink :href="route('logout')" method="post" as="button"
                                class="text-danger-600 hover:text-danger-600 hover:bg-danger-50">
                                Cerrar Sesión
                            </DropdownLink>
                        </template>
                    </Dropdown>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto w-full">
                <div class="max-w-[1280px] w-full mx-auto px-4 py-8 md:px-8 fade-in-up">
                    <header v-if="$slots.header"
                        class="mb-6 flex flex-col md:flex-row md:items-end justify-between gap-4">
                        <div>
                            <slot name="header" />
                        </div>
                    </header>

                    <slot />
                </div>
            </main>
        </div>

    </div>
</template>
