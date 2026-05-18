<script setup>
import { ref, watch } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import draggable from 'vuedraggable';
import LeadFormModal from './Partials/LeadFormModal.vue';
import LeadDetailModal from './Partials/LeadDetailModal.vue';
import { useToast } from 'vue-toastification';
import { Plus, Phone, Calendar, Pencil, UserCheck, Clock } from '@lucide/vue';

const props = defineProps({
    leads: { type: Array, required: true },
    statuses: { type: Array, required: true }
});

const toast = useToast();
const isModalOpen = ref(false);
const isDetailModalOpen = ref(false);
const selectedLead = ref(null);
const columns = ref({});

const wonModal = ref({ show: false, lead: null, targetStatus: null });

watch(() => props.leads, (newLeads) => {
    const fresh = {};
    props.statuses.forEach(status => {
        fresh[status.value] = newLeads.filter(lead => lead.status === status.value);
    });
    columns.value = fresh;
}, { immediate: true, deep: true });

const getStatusDotColor = (status) => {
    const map = {
        'NEW': 'bg-primary-500',
        'CONTACTED': 'bg-warning-500',
        'INTERESTED': 'bg-primary-300',
        'PROPOSAL': 'bg-neutral-500',
        'WON': 'bg-success-600',
        'LOST': 'bg-danger-600'
    };
    return map[status] || 'bg-neutral-400';
};

const scrollToColumn = (statusValue) => {
    const el = document.getElementById(`col-${statusValue}`);
    if (el) el.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
};

const onDragChange = (event, columnStatus) => {
    if (event.added) {
        const lead = event.added.element;
        if (columnStatus === 'WON') {
            wonModal.value = { show: true, lead, targetStatus: columnStatus };
            return;
        }
        persistStatusChange(lead, columnStatus);
    }
};

const persistStatusChange = (lead, newStatus) => {
    router.put(route('leads.updateStatus', lead.id), { status: newStatus }, {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => toast.success('Estado del lead actualizado')
    });
};

const confirmWon = () => {
    const { lead, targetStatus } = wonModal.value;
    wonModal.value.show = false;
    persistStatusChange(lead, targetStatus);
    setTimeout(() => {
        router.post(route('leads.convert', lead.id), {}, {
            preserveScroll: true,
            onSuccess: () => toast.success('Lead convertido a cliente exitosamente')
        });
    }, 800);
};

const dismissWon = () => {
    const { lead, targetStatus } = wonModal.value;
    wonModal.value.show = false;
    persistStatusChange(lead, targetStatus);
};

const openCreateModal = () => {
    selectedLead.value = null;
    isModalOpen.value = true;
};

const openEditModalFromDetail = (lead) => {
    isDetailModalOpen.value = false;
    setTimeout(() => {
        selectedLead.value = lead;
        isModalOpen.value = true;
    }, 200);
};

const openEditModal = (lead) => {
    selectedLead.value = lead;
    isModalOpen.value = true;
};

const openDetailModal = (lead) => {
    selectedLead.value = lead;
    isDetailModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
    setTimeout(() => selectedLead.value = null, 300);
};

const closeDetailModal = () => {
    isDetailModalOpen.value = false;
    setTimeout(() => selectedLead.value = null, 300);
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
    return new Intl.NumberFormat('es-PE', { style: 'currency', currency: 'PEN' }).format(value);
};

const formatDate = (date) => {
    if (!date) return null;
    return new Date(date).toLocaleDateString('es-PE');
};

const totalValue = (statusValue) => {
    const leads = columns.value[statusValue] || [];
    const sum = leads.reduce((acc, l) => acc + (parseFloat(l.estimated_value) || 0), 0);
    return sum > 0 ? formatCurrency(sum) : null;
};
</script>

<template>

    <Head title="Pipeline de Leads" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 w-full">
                <div>
                    <h2 class="text-page-title">Pipeline de Leads</h2>
                    <p class="text-body text-neutral-500 mt-1">Gestiona y avanza tus oportunidades arrastrando las
                        tarjetas.</p>
                </div>
                <button @click="openCreateModal" class="btn btn-primary whitespace-nowrap flex items-center gap-2">
                    <Plus class="w-4 h-4" />
                    Nuevo Lead
                </button>
            </div>
        </template>

        <div class="flex flex-wrap gap-2 mb-6">
            <button v-for="status in statuses" :key="status.value" @click="scrollToColumn(status.value)"
                class="flex items-center gap-2 px-3 py-1.5 rounded-full bg-white border border-neutral-200 shadow-sm hover:border-primary-400 hover:shadow-primary-100 hover:shadow-md transition text-sm font-medium text-neutral-700">
                <span :class="['w-2 h-2 rounded-full shrink-0', getStatusDotColor(status.value)]"></span>
                {{ status.label }}
                <span class="bg-neutral-100 text-neutral-600 text-[11px] font-bold px-1.5 py-0.5 rounded-full ml-0.5">
                    {{ columns[status.value]?.length || 0 }}
                </span>
            </button>
        </div>

        <div class="flex overflow-x-auto pb-10 pt-2 gap-5 items-start min-h-[70vh] w-full snap-x">
            <div v-for="status in statuses" :key="status.value" :id="`col-${status.value}`"
                class="flex-shrink-0 w-[340px] bg-neutral-100/70 border border-neutral-200 rounded-xl p-3 flex flex-col max-h-full snap-center">
                <div class="flex items-center justify-between mb-4 px-1">
                    <div class="flex items-center gap-2">
                        <span :class="['w-2 h-2 rounded-full shrink-0', getStatusDotColor(status.value)]"></span>
                        <h3 class="font-bold text-neutral-800 uppercase text-[11px] tracking-wide">{{ status.label }}
                        </h3>
                        <span
                            class="bg-white text-neutral-600 text-xs font-semibold px-2 py-0.5 rounded-full shadow-sm border border-neutral-200">
                            {{ columns[status.value]?.length || 0 }}
                        </span>
                    </div>
                    <span v-if="totalValue(status.value)" class="text-[11px] font-semibold text-success-600">
                        {{ totalValue(status.value) }}
                    </span>
                </div>

                <draggable :list="columns[status.value]" group="leads" itemKey="id"
                    @change="onDragChange($event, status.value)" class="min-h-[150px] flex-1 space-y-3"
                    ghost-class="kanban-ghost">
                    <template #item="{ element }">
                        <div @click="openDetailModal(element)"
                            class="card cursor-grab active:cursor-grabbing hover:border-primary-400 p-4 shrink-0 transition-colors relative group">

                            <button @click.stop="openEditModal(element)"
                                class="absolute top-3 right-3 text-neutral-400 hover:text-primary-500 opacity-0 group-hover:opacity-100 transition">
                                <Pencil class="w-4 h-4" />
                            </button>

                            <div class="flex items-start justify-between mb-3 gap-2 pr-6">
                                <div class="min-w-0">
                                    <h4 class="font-semibold text-neutral-900 text-sm leading-tight truncate">{{
                                        element.name }}</h4>
                                    <p class="text-[11px] text-neutral-500 mt-0.5 truncate" v-if="element.company">{{
                                        element.company }}</p>
                                </div>
                                <span v-if="element.customer_id" class="badge badge-success text-[9px] shrink-0">✓
                                    Cliente</span>
                            </div>

                            <div class="space-y-1.5 mt-2">
                                <div v-if="element.phone" class="flex items-center text-[11px] text-neutral-500 gap-2">
                                    <Phone class="w-3.5 h-3.5 text-neutral-400" />
                                    {{ element.phone }}
                                </div>
                                <div v-if="element.next_follow_up" class="flex items-center gap-1.5">
                                    <Calendar class="w-3 h-3 text-primary-400" />
                                    <span
                                        class="text-[10px] px-1.5 py-0.5 rounded bg-primary-50 text-primary-600 font-medium">
                                        {{ formatDate(element.next_follow_up) }}
                                    </span>
                                </div>
                            </div>

                            <div class="mt-4 pt-3 border-t border-neutral-100 flex items-center justify-between">
                                <div class="text-[10px] font-bold text-neutral-400 uppercase tracking-tight">{{
                                    element.source || 'Sin origen' }}</div>
                                <span class="text-sm font-semibold text-neutral-900">{{
                                    formatCurrency(element.estimated_value) }}</span>
                            </div>
                        </div>
                    </template>
                </draggable>
            </div>
        </div>
    </AuthenticatedLayout>

    <LeadFormModal :show="isModalOpen" :lead="selectedLead" @close="closeModal" />
    <LeadDetailModal :show="isDetailModalOpen" :lead="selectedLead" :statuses="statuses" @close="closeDetailModal"
        @edit="openEditModalFromDetail" />

    <Teleport to="body">
        <Transition enter-active-class="transition ease-out duration-200" enter-from-class="opacity-0"
            enter-to-class="opacity-100" leave-active-class="transition ease-in duration-150"
            leave-from-class="opacity-100" leave-to-class="opacity-0">
            <div v-if="wonModal.show" class="fixed inset-0 z-50 flex items-center justify-center p-4">
                <div class="absolute inset-0 bg-neutral-950/60 backdrop-blur-sm" @click="dismissWon"></div>
                <div class="relative z-10 bg-white rounded-2xl shadow-2xl max-w-sm w-full p-6 text-center">
                    <div
                        class="w-14 h-14 rounded-full bg-success-100 text-success-600 flex items-center justify-center mx-auto mb-4">
                        <UserCheck class="w-7 h-7" />
                    </div>
                    <h3 class="text-xl font-bold text-neutral-900 mb-1">¡Lead Ganado!</h3>
                    <p class="text-sm text-neutral-500 mb-6">
                        <strong class="text-neutral-800">{{ wonModal.lead?.name }}</strong> pasó a <strong
                            class="text-success-600">Ganado</strong>.
                        ¿Deseas convertirlo a cliente ahora?
                    </p>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <button @click="confirmWon"
                            class="btn btn-success flex-1 flex items-center justify-center gap-2">
                            <UserCheck class="w-4 h-4" />
                            Sí, convertir a Cliente
                        </button>
                        <button @click="dismissWon"
                            class="btn btn-secondary flex-1 flex items-center justify-center gap-2">
                            <Clock class="w-4 h-4" />
                            Hacerlo después
                        </button>
                    </div>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>

<style scoped>
.kanban-ghost {
    @apply opacity-40 border-2 border-dashed border-primary-400 bg-primary-100 rounded-lg;
}
</style>
