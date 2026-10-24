<template>
    <v-dialog v-model="isOpen" max-width="500px" persistent>
        <v-card class="rounded-lg pa-2">
            <v-card-title class="text-h6 font-weight-bold d-flex align-center">
                <v-icon :icon="icon" :color="color" class="me-2" size="28"></v-icon>
                {{ title }}
            </v-card-title>

            <v-card-text class="text-body-1 py-3" v-html="message">
            </v-card-text>

            <v-card-actions class="px-4 pb-2">
                <v-spacer></v-spacer>
                <v-btn variant="text" color="grey-darken-1" @click="onCancel" :disabled="loading">
                    {{ cancelText }}
                </v-btn>
                <v-btn :color="color" variant="flat" :loading="loading" @click="onConfirm">
                    {{ confirmText }}
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    modelValue: { type: Boolean, required: true },
    title: { type: String },
    message: { type: String },
    confirmText: { type: String },
    cancelText: { type: String, default: 'Cancel' },
    color: { type: String },
    icon: { type: String },
    loading: { type: Boolean, default: false }
});

const emit = defineEmits(['update:modelValue', 'confirm']);

const isOpen = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value)
});

const onCancel = () => {
    isOpen.value = false;
};

const onConfirm = () => {
    emit('confirm');
};
</script>
