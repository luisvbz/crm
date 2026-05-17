<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="flex min-h-screen items-center justify-center bg-primary-950 p-6 relative overflow-hidden">

        <!-- Decoraciones de fondo glassmorphism -->
        <div class="absolute top-[-10%] left-[-10%] w-[500px] h-[500px] bg-primary-600 rounded-full mix-blend-screen filter blur-[120px] opacity-30 animate-pulse"
            style="animation-duration: 8s;"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[600px] h-[600px] bg-primary-400 rounded-full mix-blend-screen filter blur-[140px] opacity-20 animate-pulse"
            style="animation-duration: 12s;"></div>

        <div class="relative w-full max-w-md card-glass fade-in-up p-8">
            <div class="flex flex-col items-center justify-center mb-8 gap-3">
                <Link href="/">
                    <ApplicationLogo class="h-12 w-auto fill-current text-white drop-shadow-md" />
                </Link>
                <div class="text-center">
                    <h1 class="text-2xl font-bold tracking-tight text-white mb-1">CRM<span
                            class="text-primary-300">Pro</span></h1>
                    <p class="text-sm text-primary-200">Ingresa tus credenciales para continuar</p>
                </div>
            </div>

            <slot />
        </div>
    </div>
</template>
