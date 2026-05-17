<script setup>
import { computed } from 'vue';
import { useForm as useInertiaForm } from '@inertiajs/vue3';
import { Form, Field, defineRule, configure } from 'vee-validate';
import { required, email, min, max } from '@vee-validate/rules';
import { localize } from '@vee-validate/i18n';
import es from '@vee-validate/i18n/dist/locale/es.json';
import Modal from '@/Components/Modal.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import { useToast } from 'vue-toastification';

defineRule('required', required);
defineRule('email', email);
defineRule('min', min);
defineRule('max', max);

configure({
    generateMessage: localize('es', es),
});

const props = defineProps({
    show: { type: Boolean, default: false },
    lead: { type: Object, default: () => null }
});

const emit = defineEmits(['close']);
const toast = useToast();

const inertiaForm = useInertiaForm({
    name: '',
    email: '',
    phone: '',
    company: '',
    estimated_value: '',
    source: '',
    next_follow_up: '',
    notes: '',
});

const initialValues = computed(() => {
    if (props.lead) {
        return {
            name: props.lead.name || '',
            email: props.lead.email || '',
            phone: props.lead.phone || '',
            company: props.lead.company || '',
            estimated_value: props.lead.estimated_value || '',
            source: props.lead.source || '',
            next_follow_up: props.lead.next_follow_up ? props.lead.next_follow_up.split('T')[0].split(' ')[0] : '',
            notes: props.lead.notes || '',
        };
    }
    return {
        name: '',
        email: '',
        phone: '',
        company: '',
        estimated_value: '',
        source: '',
        next_follow_up: '',
        notes: '',
    };
});

const submit = (values) => {
    Object.assign(inertiaForm, values);

    if (props.lead && props.lead.id) {
        inertiaForm.put(route('leads.update', props.lead.id), {
            preserveScroll: true,
            onSuccess: () => {
                toast.success('Lead guardado exitosamente');
                closeModal();
            },
        });
    } else {
        inertiaForm.post(route('leads.store'), {
            preserveScroll: true,
            onSuccess: () => {
                toast.success('Nuevo lead ingresado correctamente');
                closeModal();
            },
        });
    }
};

const closeModal = () => {
    inertiaForm.reset();
    inertiaForm.clearErrors();
    emit('close');
};
</script>

<template>
    <Modal :show="show" @close="closeModal" maxWidth="md">
        <div class="p-6">
            <h2 class="text-xl font-bold text-neutral-900 mb-6">
                {{ lead ? 'Editar Lead' : 'Nuevo Lead' }}
            </h2>

            <Form @submit="submit" :initial-values="initialValues" class="space-y-5">
                <div>
                    <InputLabel for="name" value="Nombre del Contacto *" />
                    <Field name="name" rules="required|max:255" v-slot="{ componentField, errors }">
                        <TextInput id="name" type="text" class="mt-1 block w-full" v-bind="componentField" />
                        <InputError class="mt-2" :message="errors[0] || inertiaForm.errors.name" />
                    </Field>
                </div>

                <div>
                    <InputLabel for="company" value="Empresa" />
                    <Field name="company" rules="max:255" v-slot="{ componentField, errors }">
                        <TextInput id="company" type="text" class="mt-1 block w-full" v-bind="componentField" />
                        <InputError class="mt-2" :message="errors[0] || inertiaForm.errors.company" />
                    </Field>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <InputLabel for="email" value="Correo Electrónico" />
                        <Field name="email" rules="email|max:255" v-slot="{ componentField, errors }">
                            <TextInput id="email" type="email" class="mt-1 block w-full" v-bind="componentField" />
                            <InputError class="mt-2" :message="errors[0] || inertiaForm.errors.email" />
                        </Field>
                    </div>

                    <div>
                        <InputLabel for="phone" value="Teléfono" />
                        <Field name="phone" rules="max:20" v-slot="{ componentField, errors }">
                            <TextInput id="phone" type="text" class="mt-1 block w-full" v-bind="componentField" />
                            <InputError class="mt-2" :message="errors[0] || inertiaForm.errors.phone" />
                        </Field>
                    </div>
                </div>

                <div>
                    <InputLabel for="estimated_value" value="Valor Estimado (S/)" />
                    <Field name="estimated_value" rules="min:0" v-slot="{ componentField, errors }">
                        <TextInput id="estimated_value" type="number" step="0.01" class="mt-1 block w-full"
                            v-bind="componentField" />
                        <InputError class="mt-2" :message="errors[0] || inertiaForm.errors.estimated_value" />
                    </Field>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <InputLabel for="source" value="Origen del Lead" />
                        <Field name="source" rules="max:255" v-slot="{ componentField, errors }">
                            <select id="source"
                                class="border-neutral-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm mt-1 block w-full"
                                v-bind="componentField">
                                <option value="">Seleccione origen</option>
                                <option value="Website">Website</option>
                                <option value="Referral">Referido</option>
                                <option value="Cold Call">Llamada en frío</option>
                                <option value="Social Media">Redes Sociales</option>
                                <option value="Event">Evento</option>
                                <option value="Other">Otro</option>
                            </select>
                            <InputError class="mt-2" :message="errors[0] || inertiaForm.errors.source" />
                        </Field>
                    </div>

                    <div>
                        <InputLabel for="next_follow_up" value="Próximo Seguimiento" />
                        <Field name="next_follow_up" v-slot="{ componentField, errors }">
                            <TextInput id="next_follow_up" type="date" class="mt-1 block w-full"
                                v-bind="componentField" />
                            <InputError class="mt-2" :message="errors[0] || inertiaForm.errors.next_follow_up" />
                        </Field>
                    </div>
                </div>

                <div>
                    <InputLabel for="notes" value="Notas / Observaciones" />
                    <Field name="notes" v-slot="{ componentField, errors }">
                        <textarea id="notes"
                            class="border-neutral-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm mt-1 block w-full"
                            rows="3" v-bind="componentField"></textarea>
                        <InputError class="mt-2" :message="errors[0] || inertiaForm.errors.notes" />
                    </Field>
                </div>

                <div class="mt-8 flex justify-end gap-3 pt-4 border-t border-neutral-100">
                    <button type="button" class="btn btn-secondary" @click="closeModal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" :disabled="inertiaForm.processing">
                        {{ lead ? 'Guardar Cambios' : 'Crear Lead' }}
                    </button>
                </div>
            </Form>
        </div>
    </Modal>
</template>
