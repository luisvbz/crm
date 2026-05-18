<script setup>
import { computed, ref } from 'vue';
import { router } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import { useToast } from 'vue-toastification';
import {
    X,
    Mail,
    Phone,
    User,
    Check,
    ArrowRight,
    Pencil,
} from '@lucide/vue';

const props = defineProps({
    show: { type: Boolean, default: false },
    lead: { type: Object, default: () => null },
    statuses: { type: Array, required: true }
});

const emit = defineEmits(['close', 'edit']);
const toast = useToast();
const isLoading = ref(false);

const closeModal = () => emit('close');

const currentStatusLabel = computed(() => {
    if (!props.lead) return '';
    const statusObj = props.statuses.find(s => s.value === props.lead.status);
    return statusObj ? statusObj.label : props.lead.status;
});

const nextStatus = computed(() => {
    if (!props.lead) return null;
    const currentIndex = props.statuses.findIndex(s => s.value === props.lead.status);
    if (currentIndex >= 0 && currentIndex < props.statuses.length - 1) {
        return props.statuses[currentIndex + 1];
    }
    return null;
});

const updateStatus = (newStatus) => {
    isLoading.value = true;
    router.put(route('leads.updateStatus', props.lead.id), {
        status: newStatus
    }, {
        preserveScroll: true,
        onSuccess: () => {
            toast.success(`Estado actualizado`);
            closeModal();
        },
        onFinish: () => { isLoading.value = false; }
    });
};

const convertLead = () => {
    isLoading.value = true;
    router.post(route('leads.convert', props.lead.id), {}, {
        preserveScroll: true,
        onSuccess: () => {
            toast.success('Lead convertido a cliente exitosamente');
            closeModal();
        },
        onFinish: () => { isLoading.value = false; }
    });
};

const formatCurrency = (value) => {
    if (!value) return '-';
    return new Intl.NumberFormat('es-PE', { style: 'currency', currency: 'PEN' }).format(value);
};

const formatDate = (date) => {
    if (!date) return '-';
    return new Date(date).toLocaleDateString('es-PE');
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
</script>

<template>
    <Modal :show="show" @close="closeModal" maxWidth="lg">
        <div class="p-6" v-if="lead">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <h2 class="text-2xl font-bold text-neutral-900">{{ lead.name }}</h2>
                        <span :class="['badge text-[10px]', getStatusColor(lead.status)]">{{ currentStatusLabel
                        }}</span>
                    </div>
                    <p class="text-sm text-neutral-500">{{ lead.company || 'Sin empresa' }}</p>
                </div>
                <button @click="closeModal" class="text-neutral-400 hover:text-neutral-600">
                    <X class="w-6 h-6" />
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-neutral-400 mb-1">Información de
                            Contacto</h4>
                        <div class="bg-neutral-50 rounded-lg p-3 space-y-2">
                            <div class="flex items-center gap-3 text-sm">
                                <Mail class="w-4 h-4 text-neutral-400 shrink-0" />
                                <span>{{ lead.email || '-' }}</span>
                            </div>
                            <div class="flex items-center gap-3 text-sm">
                                <Phone class="w-4 h-4 text-neutral-400 shrink-0" />
                                <span>{{ lead.phone || '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-neutral-400 mb-1">Detalles de Venta
                        </h4>
                        <div class="bg-neutral-50 rounded-lg p-3 space-y-3">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-neutral-500">Valor Estimado:</span>
                                <span class="font-bold text-neutral-900">{{ formatCurrency(lead.estimated_value)
                                }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-neutral-500">Origen:</span>
                                <span class="badge badge-neutral">{{ lead.source || '-' }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-neutral-500">Próximo Seguimiento:</span>
                                <span
                                    class="font-medium px-2 py-0.5 rounded text-[11px] bg-primary-50 text-primary-700">
                                    {{ formatDate(lead.next_follow_up) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-neutral-400 mb-1">Notas</h4>
                    <div
                        class="bg-neutral-50 rounded-lg p-3 text-sm min-h-[100px] whitespace-pre-wrap text-neutral-700">
                        {{ lead.notes || 'Sin notas adicionales.' }}
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-neutral-100 flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <button @click="emit('edit', lead)" class="btn btn-secondary text-sm flex items-center gap-1.5"
                        :disabled="isLoading">
                        <Pencil class="w-4 h-4" />
                        Editar Información
                    </button>

                    <button v-if="lead.status === 'WON' && !lead.customer_id" @click="convertLead()"
                        class="btn btn-success text-sm flex items-center gap-1.5" :disabled="isLoading">
                        <svg v-if="isLoading" class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                        <User v-else class="w-4 h-4" />
                        {{ isLoading ? 'Procesando...' : 'Convertir a Cliente' }}
                    </button>

                    <span v-if="lead.customer_id"
                        class="badge badge-success text-[11px] flex items-center gap-1 px-3 py-1.5">
                        <Check class="w-3.5 h-3.5" />
                        Ya convertido a Cliente
                    </span>
                </div>

                <div class="flex items-center gap-2">
                    <span class="text-xs text-neutral-400 uppercase font-bold mr-2">Mover a:</span>
                    <button v-if="nextStatus" @click="updateStatus(nextStatus.value)"
                        class="btn btn-primary text-sm flex items-center gap-1" :disabled="isLoading">
                        <svg v-if="isLoading" class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                        {{ isLoading ? 'Moviendo...' : nextStatus.label }}
                        <ArrowRight v-if="!isLoading" class="w-4 h-4 ml-1" />
                    </button>
                    <div v-else class="text-sm font-bold text-green-600 flex items-center gap-1">
                        <Check class="w-5 h-5" />
                        Lead en fase final
                    </div>
                </div>
            </div>
        </div>
    </Modal>
</template>
