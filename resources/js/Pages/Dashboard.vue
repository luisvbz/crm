<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div>
                <h2 class="text-page-title">Bienvenido, {{ $page.props.auth.user.name.split(' ')[0] }}</h2>
                <p class="text-body text-neutral-500 mt-1">Aquí tienes un resumen de la actividad de tu CRM hoy.</p>
            </div>

            <!-- Quick action -->
            <button class="btn btn-primary mt-4 md:mt-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Nuevo Lead
            </button>
        </template>

        <div class="dashboard-grid">
            <!-- KPIs -->
            <div class="col-4 card card-metric lift-on-hover">
                <h3 class="text-lg font-medium text-white/90">Leads Nuevos</h3>
                <div class="text-4xl font-bold mt-3">124</div>
                <div class="mt-4 flex items-center gap-2 text-sm text-success-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 10l7-7m0 0l7-7m7-7v18">
                        </path>
                    </svg>
                    12% vs ayer
                </div>
            </div>

            <div class="col-4 card lift-on-hover">
                <h3 class="text-label">Propuestas Enviadas</h3>
                <div class="text-metric mt-1">45</div>
                <div class="mt-4 flex items-center gap-2 text-sm text-neutral-500">
                    Pendientes de firma
                </div>
            </div>

            <div class="col-4 card lift-on-hover">
                <h3 class="text-label">Tasa de Conversión</h3>
                <div class="text-metric mt-1">28.4%</div>
                <div class="mt-4 flex items-center gap-2 text-sm text-warning-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 14l-7 7m0 0l-7-7m7 7V3">
                        </path>
                    </svg>
                    -2% vs semana pasada
                </div>
            </div>

            <!-- Table -->
            <div class="col-8 card mt-2 hidden md:block">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-card-title">Últimos Leads</h3>
                    <button class="btn btn-ghost btn-sm text-primary-500">Ver todos</button>
                </div>
                <div class="overflow-x-auto">
                    <table class="table-crm">
                        <thead>
                            <tr>
                                <th>Lead</th>
                                <th>Empresa</th>
                                <th>Estado</th>
                                <th>Valor Est.</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="font-medium text-neutral-900">Juan Pérez</div>
                                    <div class="text-xs text-neutral-500 font-mono mt-0.5">juan@ejemplo.com</div>
                                </td>
                                <td class="text-neutral-600">Tech Solutions SA</td>
                                <td><span class="badge badge-primary">NUEVO</span></td>
                                <td class="font-medium text-neutral-900">S/ 4,500.00</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="font-medium text-neutral-900">María Gómez</div>
                                    <div class="text-xs text-neutral-500 font-mono mt-0.5">maria@gomez.com</div>
                                </td>
                                <td class="text-neutral-600">Innovate Corp</td>
                                <td><span class="badge badge-warning">CONTACTADO</span></td>
                                <td class="font-medium text-neutral-900">S/ 12,000.00</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="font-medium text-neutral-900">Carlos Ruiz</div>
                                    <div class="text-xs text-neutral-500 font-mono mt-0.5">cruiz@empresa.com</div>
                                </td>
                                <td class="text-neutral-600">Empresas Ruiz</td>
                                <td><span class="badge badge-success">GANADO</span></td>
                                <td class="font-medium text-neutral-900">S/ 1,200.00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Mini Widget -->
            <div class="col-4 card mt-2">
                <h3 class="text-card-title mb-5">Tareas de Hoy</h3>
                <div class="space-y-4">
                    <div class="flex gap-3">
                        <div class="w-2.5 h-2.5 mt-1 rounded-full bg-primary-500 shadow-sm"></div>
                        <div>
                            <p class="text-sm font-medium text-neutral-900">Llamada inicial - Tech Solutions</p>
                            <p class="text-xs text-neutral-500 font-mono mt-1">10:00 AM</p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <div class="w-2.5 h-2.5 mt-1 rounded-full bg-warning-500 shadow-sm"></div>
                        <div>
                            <p class="text-sm font-medium text-neutral-900">Enviar propuesta - Innovate</p>
                            <p class="text-xs text-neutral-500 font-mono mt-1">12:30 PM</p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <div class="w-2.5 h-2.5 mt-1 rounded-full bg-neutral-300 shadow-sm"></div>
                        <div>
                            <p class="text-sm font-medium text-neutral-500 line-through">Revisar reporte semanal</p>
                            <p class="text-xs text-neutral-400 font-mono mt-1">08:00 AM</p>
                        </div>
                    </div>
                </div>
                <button class="btn btn-secondary w-full mt-6 justify-center">Abrir Calendario</button>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
