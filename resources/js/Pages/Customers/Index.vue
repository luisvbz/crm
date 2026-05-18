<script setup>
import { ref, computed } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useToast } from 'vue-toastification';
import { Search, Users, Mail, Phone, Building2, X, TrendingUp, CalendarDays, Tag } from '@lucide/vue';

const props = defineProps({
    customers: { type: Array, required: true }
});

const toast = useToast();
const search = ref('');
const selectedCustomer = ref(null);

const filteredCustomers = computed(() => {
    if (!search.value) return props.customers;
    const s = search.value.toLowerCase();
    return props.customers.filter(c =>
        c.name?.toLowerCase().includes(s) ||
        c.email?.toLowerCase().includes(s) ||
        c.company?.toLowerCase().includes(s) ||
        c.phone?.toLowerCase().includes(s)
    );
});

const openDetail = (customer) => {
    selectedCustomer.value = customer;
};

const closeDetail = () => {
    selectedCustomer.value = null;
};

const formatCurrency = (value) => {
    if (!value) return '-';
    return new Intl.NumberFormat('es-PE', { style: 'currency', currency: 'PEN' }).format(value);
};

const totalLeadValue = computed(() => {
    if (!selectedCustomer.value?.leads?.length) return null;
    const sum = selectedCustomer.value.leads.reduce((acc, l) => acc + (parseFloat(l.estimated_value) || 0), 0);
    return sum > 0 ? formatCurrency(sum) : null;
});

const statusLabelMap = {
    'NEW': 'Nuevo',
    'CONTACTED': 'Contactado',
    'INTERESTED': 'Interesado',
    'PROPOSAL': 'Propuesta',
    'WON': 'Ganado',
    'LOST': 'Perdido',
};

const statusBadge = (status) => {
    const map = {
        'WON': 'badge-success',
        'LOST': 'badge-danger',
        'NEW': 'badge-primary',
        'CONTACTED': 'badge-warning',
        'INTERESTED': 'badge-outline-primary',
        'PROPOSAL': 'badge-neutral',
    };
    return map[status] || 'badge-neutral';
};
</script>

<template>

    <Head title="Clientes" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 w-full">
                <div>
                    <h2 class="text-page-title">Clientes</h2>
                    <p class="text-body text-neutral-500 mt-1">Base de clientes activos convertidos desde el pipeline de
                        ventas.</p>
                </div>
                <div class="relative w-full max-w-xs">
                    <input v-model="search" type="text" placeholder="Buscar cliente..."
                        class="input pl-10 h-9 bg-neutral-50 w-full" />
                    <Search class="absolute left-3 top-2.5 h-4 w-4 text-neutral-400" />
                </div>
            </div>
        </template>

        <div class="flex gap-6">
            <div class="flex-1 min-w-0">
                <div v-if="filteredCustomers.length === 0"
                    class="flex flex-col items-center justify-center py-24 text-center">
                    <div class="w-16 h-16 rounded-full bg-neutral-100 flex items-center justify-center mb-4">
                        <Users class="w-8 h-8 text-neutral-400" />
                    </div>
                    <h3 class="font-semibold text-neutral-700 text-lg">Sin clientes aún</h3>
                    <p class="text-neutral-400 text-sm mt-1 max-w-xs">Los clientes aparecen aquí cuando conviertes un
                        lead
                        ganado.</p>
                </div>

                <div v-else class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                    <div v-for="customer in filteredCustomers" :key="customer.id" @click="openDetail(customer)"
                        :class="['card p-5 cursor-pointer transition-all', selectedCustomer?.id === customer.id ? 'border-primary-400 shadow-primary-100 shadow-lg' : 'hover:border-primary-300']">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-11 h-11 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center font-bold text-lg shrink-0">
                                    {{ customer.name.charAt(0).toUpperCase() }}
                                </div>
                                <div class="min-w-0">
                                    <h3 class="font-semibold text-neutral-900 leading-tight truncate">{{ customer.name
                                        }}</h3>
                                    <p class="text-xs text-neutral-500 truncate">{{ customer.company || 'Sin empresa' }}
                                    </p>
                                </div>
                            </div>
                            <span class="badge badge-success text-[10px] shrink-0">Activo</span>
                        </div>

                        <div class="space-y-1.5">
                            <div v-if="customer.email" class="flex items-center gap-2 text-xs text-neutral-500">
                                <Mail class="w-3.5 h-3.5 text-neutral-400 shrink-0" />
                                <span class="truncate">{{ customer.email }}</span>
                            </div>
                            <div v-if="customer.phone" class="flex items-center gap-2 text-xs text-neutral-500">
                                <Phone class="w-3.5 h-3.5 text-neutral-400 shrink-0" />
                                {{ customer.phone }}
                            </div>
                        </div>

                        <div v-if="customer.leads?.length"
                            class="mt-3 pt-3 border-t border-neutral-100 flex items-center justify-between">
                            <span class="text-[10px] text-neutral-400 font-bold uppercase">{{ customer.leads.length }}
                                lead{{
                                    customer.leads.length > 1 ? 's' : '' }}</span>
                            <span class="text-xs font-semibold text-success-600">
                                {{formatCurrency(customer.leads.reduce((a, l) => a + (parseFloat(l.estimated_value) ||
                                0), 0))
                                }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <Transition enter-active-class="transition duration-200 ease-out" enter-from-class="opacity-0 translate-x-4"
                enter-to-class="opacity-100 translate-x-0" leave-active-class="transition duration-150 ease-in"
                leave-from-class="opacity-100 translate-x-0" leave-to-class="opacity-0 translate-x-4">
                <div v-if="selectedCustomer" class="w-full max-w-sm shrink-0">
                    <div class="card p-5 sticky top-6">
                        <div class="flex items-start justify-between mb-5">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-12 h-12 rounded-full bg-primary-100 text-primary-700 flex items-center justify-center font-bold text-xl shrink-0">
                                    {{ selectedCustomer.name.charAt(0).toUpperCase() }}
                                </div>
                                <div>
                                    <h3 class="font-bold text-neutral-900">{{ selectedCustomer.name }}</h3>
                                    <p class="text-xs text-neutral-500">{{ selectedCustomer.company || 'Sin empresa' }}
                                    </p>
                                </div>
                            </div>
                            <button @click="closeDetail" class="text-neutral-400 hover:text-neutral-600">
                                <X class="w-5 h-5" />
                            </button>
                        </div>

                        <div class="space-y-2 mb-5">
                            <div v-if="selectedCustomer.email" class="flex items-center gap-2 text-sm text-neutral-600">
                                <Mail class="w-4 h-4 text-neutral-400 shrink-0" />
                                {{ selectedCustomer.email }}
                            </div>
                            <div v-if="selectedCustomer.phone" class="flex items-center gap-2 text-sm text-neutral-600">
                                <Phone class="w-4 h-4 text-neutral-400 shrink-0" />
                                {{ selectedCustomer.phone }}
                            </div>
                            <div v-if="selectedCustomer.company"
                                class="flex items-center gap-2 text-sm text-neutral-600">
                                <Building2 class="w-4 h-4 text-neutral-400 shrink-0" />
                                {{ selectedCustomer.company }}
                            </div>
                        </div>

                        <div v-if="selectedCustomer.notes" class="mb-5 bg-neutral-50 rounded-lg p-3">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-neutral-400 mb-1">Notas</p>
                            <p class="text-xs text-neutral-600 whitespace-pre-wrap">{{ selectedCustomer.notes }}</p>
                        </div>

                        <div v-if="selectedCustomer.leads?.length">
                            <div class="flex items-center justify-between mb-3">
                                <p
                                    class="text-[10px] font-bold uppercase tracking-wider text-neutral-400 flex items-center gap-1.5">
                                    <TrendingUp class="w-3.5 h-3.5" />
                                    Leads Asociados
                                </p>
                                <span v-if="totalLeadValue" class="text-xs font-bold text-success-600">{{ totalLeadValue
                                    }}</span>
                            </div>
                            <div class="space-y-2">
                                <div v-for="lead in selectedCustomer.leads" :key="lead.id"
                                    class="bg-neutral-50 rounded-lg p-3 flex items-center justify-between gap-2">
                                    <div class="flex items-center gap-2 min-w-0">
                                        <span :class="['badge text-[9px] shrink-0', statusBadge(lead.status)]">
                                            {{ statusLabelMap[lead.status] || lead.status }}
                                        </span>
                                    </div>
                                    <span class="text-xs font-semibold text-neutral-700 shrink-0">
                                        {{ formatCurrency(lead.estimated_value) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div v-else class="text-center py-6 text-neutral-400 text-sm">
                            Sin leads asociados.
                        </div>
                    </div>
                </div>
            </Transition>
        </div>
    </AuthenticatedLayout>
</template>
