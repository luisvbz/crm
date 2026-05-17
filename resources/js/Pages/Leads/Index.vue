<script setup>
import { ref } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import draggable from 'vuedraggable';

const props = defineProps({
    leads: {
        type: Array,
        required: true
    },
    statuses: {
        type: Array,
        required: true
    }
});


const columns = ref({});

props.statuses.forEach(status => {
    columns.value[status] = props.leads.filter(lead => lead.status === status);
});

// Evento al soltar tarjeta en otra lista
const onDragChange = (event, columnStatus) => {
    if (event.added) {
        const lead = event.added.element;
        // Petición PUT para lanzar el UpdateLeadStatusAction
        router.put(route('leads.updateStatus', lead.id), {
            status: columnStatus
        }, {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                // Podríamos mostrar un Toast aquí gracias al Inerita visit successful
            }
        });
    }
};

const getStatusColor = (status) => {
    const map = {
        'NEW': 'badge-primary',
        'CONTACTED': 'badge-warning',
        'INTERESTED': 'badge-outline-primary',
        'PROPOSAL': 'badge-neutral',
        'WON': 'badge-success',
        'LOST': 'badge-danger'
    };
    return map[status] || 'badge-neutral';
};

const formatCurrency = (value) => {
    if (!value) return '-';
    // Formatear la moneda usando el API nativo de Intl
    return new Intl.NumberFormat('es-PE', { style: 'currency', currency: 'PEN' }).format(value);
};
</script>

<template>

    <Head title="Pipeline de Leads" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 w-full">
                <div>
                    <h2 class="text-page-title">Pipeline de Leads</h2>
                    <p class="text-body text-neutral-500 mt-1">Gestiona y avanza tus oportunidades de venta arrastrando
                        las tarjetas.</p>
                </div>
                <!-- Ideal para disparar un Modal más adelante -->
                <button
                    v-if="$page.props.auth.permissions && ($page.props.auth.permissions.includes('manage leads') || $page.props.auth.permissions.includes('update own leads'))"
                    class="btn btn-primary whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Nuevo Lead
                </button>
            </div>
        </template>

        <!-- Kanban Board Area -->
        <div class="flex overflow-x-auto pb-10 pt-2 gap-5 items-start min-h-[70vh] w-full snap-x">

            <div v-for="status in statuses" :key="status"
                class="flex-shrink-0 w-[340px] bg-neutral-100/70 border border-neutral-200 rounded-xl p-3 flex flex-col max-h-full snap-center">
                <!-- Column Header -->
                <div class="flex items-center justify-between mb-4 px-1">
                    <div class="flex items-center gap-2">
                        <h3 class="font-bold text-neutral-800 uppercase text-[11px] tracking-wide">{{ status }}</h3>
                        <span
                            class="bg-white text-neutral-600 text-xs font-semibold px-2 py-0.5 rounded-full shadow-sm border border-neutral-200">
                            {{ columns[status].length }}
                        </span>
                    </div>
                </div>

                <!-- Draggable Container -->
                <draggable :list="columns[status]" group="leads" itemKey="id"
                    :disabled="!$page.props.auth.permissions || !($page.props.auth.permissions.includes('manage leads') || $page.props.auth.permissions.includes('update own leads'))"
                    @change="onDragChange($event, status)" class="min-h-[150px] flex-1 space-y-3"
                    ghost-class="opacity-40 border-2 border-dashed border-primary-400 bg-primary-100 rounded-lg">
                    <template #item="{ element }">
                        <div
                            class="card cursor-grab active:cursor-grabbing hover:border-primary-400 p-4 shrink-0 transition-colors">
                            <div class="flex items-start justify-between mb-3 gap-2">
                                <div class="min-w-0">
                                    <h4 class="font-semibold text-neutral-900 text-sm leading-tight truncate">{{
                                        element.name }}</h4>
                                    <p class="text-[11px] text-neutral-500 mt-0.5 truncate" v-if="element.company">{{
                                        element.company }}</p>
                                </div>
                                <span :class="['badge shrink-0', getStatusColor(status)]"
                                    class="text-[9px] px-1.5 py-0.5">
                                    {{ status }}
                                </span>
                            </div>

                            <div class="space-y-1.5 mt-3">
                                <div class="flex items-center text-[11px] text-neutral-500 gap-2" v-if="element.email">
                                    <svg class="w-3.5 h-3.5 text-neutral-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.53 4.518a2 2 0 002.53 0L21 8m-9 13h9a2 2 0 002-2V5a2 2 0 00-2-2H3a2 2 000-2 2v14a2 2 000 2 2z">
                                        </path>
                                    </svg>
                                    <span class="truncate">{{ element.email }}</span>
                                </div>
                                <div class="flex items-center text-[11px] text-neutral-500 gap-2" v-if="element.phone">
                                    <svg class="w-3.5 h-3.5 text-neutral-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                        </path>
                                    </svg>
                                    {{ element.phone }}
                                </div>
                            </div>

                            <div class="mt-4 pt-3 border-t border-neutral-100 flex items-center justify-between"
                                v-if="element.estimated_value">
                                <span class="text-[10px] uppercase font-bold tracking-wide text-neutral-400">Valor
                                    Est.</span>
                                <span class="text-sm font-semibold text-neutral-900">{{
                                    formatCurrency(element.estimated_value) }}</span>
                            </div>
                        </div>
                    </template>
                </draggable>
            </div>

        </div>
    </AuthenticatedLayout>
</template>
